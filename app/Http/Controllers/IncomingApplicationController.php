<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationMovement;
use App\Models\ApplicationStatus;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IncomingApplicationController extends Controller
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
            ->when($search,fn(Builder $builder)=>$builder->where('head_of_family','LIKE',"%$search%"))
            ->when($filterDistrictId,fn(Builder $builder)=>$builder->whereHas('district',fn($q)=>$q->where('id',$filterDistrictId)))
            ->when($filterConstituencyId,fn(Builder $builder)=>$builder->whereHas('constituency',fn($q)=>$q->where('id',$filterConstituencyId)))
            ->when($filterDepartmentId,fn(Builder $builder)=>$builder->whereHas('department',fn($q)=>$q->where('id',$filterDepartmentId)))
            ->when($filterTradeId,fn(Builder $builder)=>$builder->whereHas('trade',fn($q)=>$q->where('id',$filterTradeId)))
            ->whereHas('lastMovement', fn(Builder $builder) => $builder->where('recipient_id',auth()->id())->whereNull('received_at'))
            ->paginate($perPage);
        return inertia('Backend/Application/Incoming/Index', [
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

    public function sendBack(Request $request, Application $model)
    {
        $first=$model->lastMovement()->first();
        $model->applicationMovements()->create([
            'sender_id'=>auth()->id(),
            'recipient_id'=>$first->sender_id,
            'received_at'=>null,
            'sent_at'=>now(),
            'type'=>ApplicationMovement::INSIDE,
            'remark'=>'dd'
        ]);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application send back successfully'
        ]);
        return to_route('application.received');
    }
    public function bulkTake(Request $request)
    {
        $data=$this->validate($request, [
            'ids'=>['required']
        ]);

        foreach ($data['ids'] as $id) {
            $application=Application::query()->find($id);

            $application->lastMovement()->update([
                'recipient_id'=>auth()->id(),
                'received_at'=>now()
            ]);
        }

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application taken successfully'
        ]);

        return redirect()->back();
    }




}
