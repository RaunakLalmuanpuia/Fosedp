<?php

namespace App\Http\Controllers;

use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\SubTrade;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function masterData(Request $request)
    {
        return [

            'districts' => District::query()->get(),
            'constituencies' => Constituency::query()->get(),
            'departments' => Department::query()->get(),
            'trades' => Trade::query()->get(),
            'subTrades'=>SubTrade::query()->get(),
        ];
    }
    public function subTrades(Request $request, Trade $trade)
    {
        $search = $request->get('search');
        return response()->json([
            'list'=>$trade->subTrades()
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"$search%"))
                ->take(15)
        ]);
    }

    public function trades(Request $request, Department $department)
    {
        $search = $request->get('search');
        return response()->json([
            'list'=>$department
                ->trades()
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"$search%"))
            ->take(25)
        ]);
    }

    public function districtConstituency(Request $request, District $district)
    {
        $search = $request->get('search');
        return response()->json([
            'list'=>        $district->constituencies()
            ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"$search%"))
        ]);
    }
}
