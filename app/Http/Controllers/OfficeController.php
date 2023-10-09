<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\District;
use App\Models\Office;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->get('rowPerPage') ?? 15;
        $search = $request->get('search') || '';
        return inertia('Backend/Office/Index',[
            'list'=>Office::query()
                ->with(['district','department'])
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"%$search%"))
                ->paginate($perPage),
            'districts'=>District::query()->get(['id as value','name as label']),
            'search' => $search,
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/Office/Create',[
            'offices' => Office::query()->get(['id as value', 'name as label']),
            'districts' => District::query()->get(['id as value', 'name as label']),
            'departments' => Department::query()->get(['id as value', 'name as label']),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData=$this->validate($request, [
            'name'=>'required',
            'district_id'=>'required',
            'department_id'=>'required',
            'level'=>'required'
        ]);

        $parentOffice = $request->has('office');
        $office=Office::query()->create($validatedData);
        if ($parentOffice) {
            $office->parent_id = $parentOffice;
            $office->save();
        }
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Office created successfully'
        ]);

        return to_route('office.index');
    }

    public function edit(Request $request,Office $office)
    {

    }

    public function update(Request $request, Office $office)
    {
        $office->update([]);
    }

    public function destroy(Request $request,Office $office)
    {
        $office->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Office created successfully'
        ]);

        return to_route('office.index');

    }

}
