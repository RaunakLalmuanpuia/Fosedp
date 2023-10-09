<?php

namespace App\Http\Controllers;

use App\Models\Constituency;
use App\Models\District;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConstituencyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page') ?? 15;
        return inertia('Backend/Constituency/Index', [
            'list' => Constituency::query()
                ->with(['district'])
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"%$search%"))
                ->latest()
                ->paginate($perPage),
        ]);
    }

    public function store(Request $request)
    {
        $data=$this->validate($request, [
            'name' => 'required',
            'district_id'=>['required',Rule::exists('districts','id')]
        ]);
        Constituency::query()->create($data);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency created successfully'
        ]);

        return to_route('constituency.index');

    }

    public function create(Request $request)
    {
        return inertia('Backend/Constituency/Create',[
            'districts'=>District::query()->get(['id as value','name as label','id as district_id'])
        ]);
    }

    public function edit(Request $request,Constituency $constituency)
    {
        return inertia('Backend/Constituency/Edit',[
            'data'=>$constituency->load(['district']),
            'districts'=>District::query()->get(['id as value','name as label'])
        ]);
    }

    public function update(Request $request, Constituency $constituency)
    {
        $data=$this->validate($request, [
            'name' => 'required',
            'district_id'=>'required'
        ]);
        $constituency->update($data);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency updated successfully'
        ]);

        return to_route('constituency.index');
    }

    public function destroy(Request $request, Constituency $constituency)
    {
        $constituency->delete();

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency deleted successfully'
        ]);
        return to_route('constituency.index');

    }
    public function detach(Request $request, Constituency $constituency)
    {

        $constituency->district()->dissociate()->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Constituency removed from district successfully'
        ]);
        return back();
    }
}
