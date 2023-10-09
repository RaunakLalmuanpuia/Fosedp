<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return inertia('Backend/Department/Index', [
            'list' => Department::query()
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"$search%"))
                ->latest()
                ->paginate(),
        ]);
    }
    public function create(Request $request)
    {
        return inertia('Backend/Department/Create');
    }
    public function edit(Request $request, Department $department)
    {
        return inertia('Backend/Department/Edit',[
            'data'=>$department->load(['users','trades'])
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required'
        ]);
        $department=Department::query()->create($request->only(['name']));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Department created successfully'
        ]);
        return to_route('department.index');
    }

    public function update(Request $request, Department $department)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required'
        ]);
        $department->update($request->only(['name']));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Department updated successfully'
        ]);
        return to_route('department.index');
    }

    public function destroy(Request $request,Department $department)
    {
        $department->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Department deleted successfully'
        ]);
        return to_route('department.index');
    }
}
