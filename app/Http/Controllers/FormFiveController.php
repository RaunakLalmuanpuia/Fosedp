<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\FormEleven;
use App\Models\FormFive;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FormFiveController extends Controller
{
    public function all(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormFive/Admin', [
            'list' => FormFive::query()->with(['user','department'])
                ->where('type','one')
                ->when($filter,fn(Builder $builder)=>$builder->whereIn('department_id',$filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value','name as label']),
            'filter'=>Department::query()->whereIn('id',$filter)->get(['id as value','name as label'])
        ]);
    }
    public function allTwo(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormFiveTwo/Admin', [
            'list' => FormFive::query()->with(['user','department'])
                ->where('type','two')
                ->when($filter,fn(Builder $builder)=>$builder->whereIn('department_id',$filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value','name as label']),
            'filter'=>Department::query()->whereIn('id',$filter)->get(['id as value','name as label'])
        ]);
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormFive/Index', [
            'list' => FormFive::query()->with(['user','department'])
                ->where('type','one')
                ->whereHas('department',fn(Builder $builder)=>$builder->whereIn('id',$departments))
                ->get()
        ]);
    }
    public function indexTwo(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormFive/Index', [
            'list' => FormFive::query()->with(['user','department'])
                ->where('type','two')
                ->whereHas('department',fn(Builder $builder)=>$builder->whereIn('id',$departments))
                ->get()
        ]);
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormFive/Create', [
            'list' => FormEleven::query()->get(),
            'departments'=>$user->departments()->get(['departments.id as value','departments.name as label'])
        ]);
    }
    public function createTwo(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormFiveTwo/Create', [
            'list' => FormEleven::query()->get(),
            'departments'=>$user->departments()->get(['departments.id as value','departments.name as label'])
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type'=>'required',
            'attachment' => ['required', Rule::file()],
            'department_id' => ['required', Rule::exists('departments','id')]
        ]);
        $file = $request->file('attachment');
        $path=Storage::disk('public')->put('form-five',$file);
        $data=FormFive::query()->create([
            'user_id' => auth()->id(),
            'department_id' => $request->get('department_id'),
            'remark' => $request->get('remark'),
            'type' => $request->get('type'),
            'path'=>$path
        ]);
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Form Five uploaded successfully'
        ]);
        return $request->get('type')==='one'? to_route('form-five.index') : to_route('form-five-two.index');
    }

    public function destroy(Request $request, FormFive $form)
    {
        $deleted=Storage::disk('public')->delete($form->path);
        if ($deleted) {
            $form->delete();
        }
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Form Five deleted successfully'
        ]);
        return to_route('form-five.index');
    }

}
