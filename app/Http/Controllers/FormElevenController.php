<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\FormEleven;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FormElevenController extends Controller
{
    public function all(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormEleven/Admin', [
            'list' => FormEleven::query()->with(['user','department'])
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
        return inertia('Backend/FormEleven/Index', [
            'list' => FormEleven::query()->with(['user','department'])
                ->whereHas('department',fn(Builder $builder)=>$builder->whereIn('id',$departments))
                ->get()
        ]);
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormEleven/Create', [
            'list' => FormEleven::query()->get(),
            'departments'=>$user->departments()->get(['departments.id as value','departments.name as label'])
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'attachment' => ['required', Rule::file()],
            'department_id' => ['required', Rule::exists('departments','id')]
        ]);
        $file = $request->file('attachment');
        $path=Storage::disk('public')->put('form-eleven',$file);
        $data=FormEleven::query()->create([
            'user_id' => auth()->id(),
            'department_id' => $request->get('department_id'),
            'remark' => $request->get('remark'),
            'path'=>$path
        ]);
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Form Five uploaded successfully'
        ]);
        return to_route('form-eleven.index');
    }

    public function destroy(Request $request, FormEleven $form)
    {
        $deleted=Storage::disk('public')->delete($form->path);
        if ($deleted) {
            $form->delete();
        }
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Form Five deleted successfully'
        ]);
        return to_route('form-eleven.index');
    }
}
