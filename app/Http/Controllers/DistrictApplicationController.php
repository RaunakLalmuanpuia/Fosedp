<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\User;
use App\Models\UserDistrict;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DistrictApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $ids=$user->districts()->pluck('id');


        $districts=District::query()->whereIn('id', $ids)
            ->get(['id as value','name as label']);


        $constituencies=Constituency::query()
            ->whereIn('district_id', $districts->map(fn(District $district) => $district->id))
            ->get(['id as value','name as label']);


        return inertia('Backend/Application/DistrictApplication/Index', [
            'districts' => $districts,
            'district'=>blank($districts) ?[]:$districts[0],
            'constituencies'=>$constituencies,
            'departments'=>Department::query()->get(['id as value','name as label']),
        ]);
    }

    public function all(Request $request){
        $user = auth()->user();

        $search = $request->get('search');
        $district=$request->get('district_id');
        $constituency=$request->get('constituency_id');
        $department=$request->get('department_id');
        $trade=$request->get('trade_id');
        $ids=$user->districts()->pluck('id');
        $list=Application::query()
            ->with(['district','constituency','trade','subTrade','lastMovement','department','firstMovement'])
            ->when($search,fn(Builder $builder)=>$builder->where('head_of_family','LIKE',"%$search%"))
            ->when($constituency,fn(Builder $builder)=>$builder->where('constituency_id',$constituency))
            ->when($department,fn(Builder $builder)=>$builder->where('department_id',$constituency))
            ->when($trade,fn(Builder $builder)=>$builder->where('trade_id',$trade))
            ->when($district,fn(Builder $builder)=>$builder->where('district_id',$district))
            ->whereIn('district_id', $ids)
            ->paginate();


        return response()->json([
            'list' => $list,
        ]);
    }


}
