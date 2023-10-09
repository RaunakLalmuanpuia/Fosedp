<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\District;
use App\Models\SubTrade;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TradeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page') ?? 15;
        return inertia('Backend/Trade/Index', [
            'search' => $search ?? '',
            'list' => Trade::query()
                ->with(['department'])
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"%$search%"))
                ->latest()
                ->paginate($perPage),
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/Trade/Create',[
            'departments'=>Department::query()->orderBy('name')->get(['id as value','name as label'])
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'department_id'=>'required'
        ]);
        Trade::query()->create($request->only(['name','department_id', 'description']));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency created successfully'
        ]);
        return to_route('trade.index');
    }

    public function edit(Request $request, Trade $trade)
    {
        return inertia('Backend/Trade/Edit', [
            'data'=>$trade->load(['department','subTrades']),
            'departments'=>Department::query()->orderBy('name')
                ->get(['id as value','name as label'])
        ]);
    }

    public function update(Request $request, Trade $trade)
    {
        $this->validate($request, [
            'name'=>'required',
            'department_id'=>['required',Rule::exists('departments','id')]
        ]);
        $trade->update($request->only(['name','department_id', 'description']));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency updated successfully'
        ]);
        return to_route('trade.index');
    }

    public function destroy(Request $request, Trade $trade)
    {
        $trade->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency created successfully'
        ]);
        return to_route('trade.index');
    }

    public function detach(Request $request, Trade $trade)
    {
        $trade->department()->disassociate()->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Trade detached successfully'
        ]);
        return back();
    }

    public function storeSubtrade(Request $request,Trade $trade)
    {
        $trade->subTrades()->create($request->only('name'));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Subtrade created successfully'
        ]);
        return back();
    }
    public function detachSubTrade(Request $request, SubTrade $subTrade)
    {

        $subTrade->trade()->disassociate()->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Subtrade detached successfully'
        ]);
        return back();
    }
}
