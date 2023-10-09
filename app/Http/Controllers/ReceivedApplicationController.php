<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationMovement;
use App\Models\ApplicationStatus;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReceivedApplicationController extends Controller
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
            ->with(['district','constituency','trade','department','subTrade','currentStatus'])
            ->when($search,fn(Builder $builder)=>$builder->where('head_of_family','LIKE',"$search%"))
            ->when($filterDistrictId,fn(Builder $builder)=>$builder->whereHas('district',fn($q)=>$q->where('id',$filterDistrictId)))
            ->when($filterConstituencyId,fn(Builder $builder)=>$builder->whereHas('constituency',fn($q)=>$q->where('id',$filterConstituencyId)))
            ->when($filterDepartmentId,fn(Builder $builder)=>$builder->whereHas('department',fn($q)=>$q->where('id',$filterDepartmentId)))
            ->when($filterTradeId,fn(Builder $builder)=>$builder->whereHas('trade',fn($q)=>$q->where('id',$filterTradeId)))
            ->whereHas('lastMovement', fn(Builder $builder) => $builder->where('recipient_id',auth()->id())->whereNotNull('received_at'))
            ->paginate($perPage);
        return inertia('Backend/Application/Received/Index', [
            'canVerify'=>$user->hasAnyRole(['dc-verifier']),
            'canApprove'=>$user->hasAnyRole(['dc-approval']),
            'canPlanningVerify'=>$user->hasAnyRole(['planning']),
            'canPlanningApprove'=>$user->hasAnyRole(['planning']),
            'canExecutiveApprove'=>$user->hasAnyRole(['executive']),
            'canBoardApprove'=>$user->hasAnyRole(['governing']),
            'search'=>$search,
            'list' => $list,
            'districts'=>District::query()
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

    public function bulkVerify(Request $request)
    {

        abort_if(!$request->user()->hasAnyRole(['dc-verifier']),403,'Permission Denied');
        $validated=$this->validate($request, [
            'ids' => 'required'
        ]);

        $applications=Application::query()->whereIn('id', $validated['ids'])->get();
        $applications->each(function (Application $application) {
            $application->currentStatus()->update([
                'name' => ApplicationStatus::VERIFIED,
                'user_id' => auth()->id()
            ]);
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Bulk verification done successfully'
        ]);
        return back();
    }

    public function bulkSendBack(Request $request)
    {

        $validatedData=$this->validate($request, [
            'ids'=>['required',Rule::exists('applications','id')],
        ]);
        $data=collect($validatedData['ids'])
            ->map(function ($id) use ( $validatedData) {
                $application = Application::query()->find($id);
                $recipient=$application->lastMovement->sender_id;
                return [
                    'application_id' => $id,
                    'sender_id' => auth()->id(),
                    'recipient_id' => $recipient,
                    'received_at' => null,
                    'sent_at' => now(),
                    'type' => ApplicationMovement::INSIDE,
                    'remark' => 'send back'
                ];
            })->toArray();

        ApplicationMovement::query()->insert( $data);
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application send back successfully'
        ]);
        return redirect()->back();
    }
    public function bulkApprove(Request $request)
    {
        abort_if(!$request->user()->hasAnyRole(['dc-approval']),403,'Permission Denied');
        $validated=$this->validate($request, [
            'ids' => 'required'
        ]);
        $applications=Application::query()->whereIn('id', $validated['ids'])->get();
        $applications->each(function (Application $application) {
            $application->currentStatus()->update([
                'name' => ApplicationStatus::APPROVED,
                'user_id' => auth()->id()
            ]);
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Bulk approve done successfully'
        ]);
        return back();
    }
    public function bulkPlanningVerify(Request $request)
    {
        abort_if(!$request->user()->hasAnyRole(['planning']),403,'Permission Denied');
        $validated=$this->validate($request, [
            'ids' => 'required'
        ]);

        $applications=Application::query()->whereIn('id', $validated['ids'])->get();
        $applications->each(function (Application $application) {
            $application->currentStatus()->update([
                'name' => ApplicationStatus::PLANNING_VERIFIED,
                'user_id' => auth()->id()
            ]);
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Bulk verified done successfully'
        ]);
        return back();
    }
    public function bulkPlanningApprove(Request $request)
    {
        abort_if(!$request->user()->hasAnyRole(['planning']),403,'Permission Denied');
        $validated=$this->validate($request, [
            'ids' => 'required'
        ]);
        $applications=Application::query()->whereIn('id', $validated['ids'])->get();
        $applications->each(function (Application $application) {
            $application->currentStatus()->update([
                'name' => ApplicationStatus::PLANNING_APPROVED,
                'user_id' => auth()->id()
            ]);
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Bulk approve done successfully'
        ]);
        return back();
    }
    public function bulkExecutiveApprove(Request $request)
    {
        abort_if(!$request->user()->hasAnyRole(['executive']),403,'Permission Denied');
        $validated=$this->validate($request, [
            'ids' => 'required'
        ]);
        $applications=Application::query()->whereIn('id', $validated['ids'])->get();
        $applications->each(function (Application $application) {
            $application->currentStatus()->update([
                'name' => ApplicationStatus::EXECUTIVE_APPROVED,
                'user_id' => auth()->id()
            ]);
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Bulk approve done successfully'
        ]);
        return back();
    }
    public function bulkBoardApprove(Request $request)
    {
        abort_if(!$request->user()->hasAnyRole(['governing']),403,'Permission Denied');
        $validated=$this->validate($request, [
            'ids' => 'required'
        ]);
        $applications=Application::query()->whereIn('id', $validated['ids'])->get();
        $applications->each(function (Application $application) {
            $application->currentStatus()->update([
                'name' => ApplicationStatus::GOVERNING_APPROVED,
                'user_id' => auth()->id()
            ]);
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Bulk approve done successfully'
        ]);
        return back();
    }


}
