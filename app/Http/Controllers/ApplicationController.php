<?php

namespace App\Http\Controllers;

use App\Jobs\SmsJob;
use App\Models\Application;
use App\Models\ApplicationMovement;
use App\Models\ApplicationStatus;
use App\Models\BankAccount;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{


    public function index(Request $request)
    {

        $user = auth()->user();
        $search = $request->get('search');
        $district_ids = $user->districts()->pluck('id') ?? [];
        $perPage = $request->get('per_page') ?? 15;

        $filterDistrictId = $request->get('filter_district_id');
        $filterConstituencyId = $request->get('filter_constituency_id');
        $filterDepartmentId = $request->get('filter_department_id');
        $filterTradeId = $request->get('filter_trade_id');
        $list=Application::query()
            ->with(['district','constituency','trade','department','subTrade'])
            ->when($search,fn(Builder $builder)=>$builder->where('head_of_family','LIKE',"$search%"))
            ->when($filterDistrictId,fn(Builder $builder)=>$builder->whereHas('district',fn($q)=>$q->where('id',$filterDistrictId)))
            ->when($filterConstituencyId,fn(Builder $builder)=>$builder->whereHas('constituency',fn($q)=>$q->where('id',$filterConstituencyId)))
            ->when($filterDepartmentId,fn(Builder $builder)=>$builder->whereHas('department',fn($q)=>$q->where('id',$filterDepartmentId)))
            ->when($filterTradeId,fn(Builder $builder)=>$builder->whereHas('trade',fn($q)=>$q->where('id',$filterTradeId)))
            ->paginate($perPage);
        return inertia('Backend/Application/Index', [
            'search'=>$search,
            'list' => $list,
            'districts'=>District::query()
                ->whereIn('id',$district_ids)
                ->get(['id as value','name as label']),
            'departments'=>Department::query()
                ->get(['id as value','name as label']),
            'filter'=>[
                'department'=>Department::query()->where('id',$filterDepartmentId)->first(['id as value','name as label']),
                'constituency'=>Constituency::query()->where('id',$filterConstituencyId)->first(['id as value','name as label']),
                'district'=>District::query()->where('id',$filterDistrictId)->first(['id as value','name as label']),
                'trade'=>Trade::query()->where('id',$filterTradeId)->first(['id as value','name as label']),
            ],

        ]);
    }
    public function create(Request $request)
    {
        $user = auth()->user();
        $districts=$user->districts()->get(['id as value','name as label']);
        $departments = Department::query()->get(['id as value', 'name as label']);

        return inertia('Backend/Application/Create',[
            'districts' => $districts,
            'departments'=>$departments
        ]);
    }

    public function store(Request $request)
    {
        $validatedData=$this->validate($request, [
            'head_of_family'=>'required',
            'mobile'=>'required',
            'address'=>'required',
            'epic_no'=>['required',Rule::unique('applications','epic_no')],
            'district_id'=>['required',Rule::exists('districts','id')],
            'constituency_id'=>['required',Rule::exists('constituencies','id')],
            'trade_id'=>['required',Rule::exists('trades','id')],
        ]);
        $bankData = $this->validate($request, [
            'bank_name'=>'required',
            'branch_name'=>'required',
            'ac_no'=>'required',
            'ac_holder'=>'required',
            'ifsc'=>'required'
        ]);
        $validatedData = array_merge($validatedData, ['sub_trade_id' => $request->get('subtrade_id')]);


        $application=DB::transaction(function () use ($bankData, $validatedData) {
            $application=Application::query()->create(array_merge($validatedData,[
                'department_id'=>Trade::query()->find($validatedData['trade_id'])->department_id
            ]));
            $application->applicationStatuses()->create([
                'name'=>ApplicationStatus::SUBMITTED,

            ]);
            $application->bankAccount()->create($bankData);
            ApplicationMovement::query()->create([
                'application_id'=>$application->id,
                'sender_id'=>auth()->id(),
                'recipient_id'=>auth()->id(),
                'received_at'=>now(),
                'sent_at'=>now(),
                'type'=>ApplicationMovement::INSIDE,
                'remark'=>'Application registration'
            ]);
            return $application;
        });
        if ($application) {
            $this->dispatch((new SmsJob($application?->mobile))->delay(30));
        }

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application submitted successfully'
        ]);
        return to_route('application.received');
    }


    public function show(Request $request,Application $model)
    {

        $pullable=$model->lastMovement()->whereNull('received_at')->where('sender_id',auth()->id())->exists();
        $takeable=$model->lastMovement()->whereNull('received_at')->where('recipient_id',auth()->id())->exists();
        $received=$model->lastMovement()->whereNotNull('received_at')->where('recipient_id',auth()->id())->exists();

        abort_if(!($pullable || $takeable || $received || $request->user()->hasRole(['admin','planning'])),403);

        return inertia('Backend/Application/Show',[
            'data'=>$model->load(['bankAccount','district','constituency','trade','department','subTrade','lastMovement','currentStatus']),
            'audits' => $model->audits()->with(['user'])->get(),
            'bank_audit' => BankAccount::query()->where('application_id',$model->id)->first()->audits()->with('user')->get(),
            'pullable' => $pullable,
            'takeable'=>$takeable,
            'received'=>$received || $request->user()->hasRole(['planning']),
            'canEdit'=> $received===true,
            'canDelete'=> $request->user()->hasRole(['admin']) ||  $received,
            'forwardTo' => $this->recipientRole(\auth()->user()),
            'canSendBack'=>$model->lastMovement()->first()?->sender_id!==auth()->id()
        ]);
    }

    public function edit(Request $request, Application $model)
    {
        $user = auth()->user();
        $districts=$user->districts()->get(['id as value','name as label']);
        $departments = Department::query()->get(['id as value', 'name as label']);

        return inertia('Backend/Application/Edit',[
            'data'=>$model->load(['district','department','trade','subTrade','constituency','bankAccount']),
            'districts'=>$districts,
            'departments'=>$departments
        ]);
    }
    public function update(Request $request, Application $model)
    {

        $validatedData=$this->validate($request, [
            'head_of_family'=>'required',
            'mobile'=>'required',
            'address'=>'required',
            'epic_no'=>['required',Rule::unique('applications','epic_no')->ignore($model->id)],
            'district_id'=>['required',Rule::exists('districts','id')],
            'constituency_id'=>['required',Rule::exists('constituencies','id')],
            'trade_id'=>['required',Rule::exists('trades','id')],
            'department_id'=>['required',Rule::exists('departments','id')],
        ]);
        $bankData = $this->validate($request, [
            'bank_name'=>'required',
            'branch_name'=>'required',
            'ac_no'=>'required',
            'ac_holder'=>'required',
            'ifsc'=>'required'
        ]);

        $validatedData = array_merge($validatedData, ['sub_trade_id' => $request->get('subtrade_id')]);

        DB::transaction(function () use ($model, $bankData, $validatedData) {
            $model->update($validatedData);
            $bankAccount=BankAccount::query()->where('application_id', $model->id)->first();

            $bankAccount->update($bankData);
        });

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application updated successfully'
        ]);

        return to_route('application.received');
    }

    public function destroy(Request $request, Application $model)
    {
        $model->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application submitted successfully'
        ]);
        return to_route('application.received');

    }

    public function getAudits(Request $request,Application $application)
    {

        return[
            'data' =>  $application->audits()->with(['user','bankAccount'])->get(),
        ];

    }

    private function recipientRole(User $user)
    {
        $roles=$user->getRoleNames();
        foreach ($roles as $role) {
            return match ($role) {
                'dc' => ['dc-verifier'],
                'dc-verifier' => ['dc-approval','dc'],
                'dc-approval' => ['planning','dc-verifier'],
                'executive' => ['planning'],
                'planning' => ['executive', 'department', 'dc'],
                'department' => ['office', 'planning'],
                'office' => ['department', 'dc'],
                'admin' => ['department', 'dc','planning','executive','office'],
                default => [],
            };
        }
    }

}
