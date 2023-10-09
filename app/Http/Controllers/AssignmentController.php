<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssignmentController extends Controller
{
    public function assignDepartment(Request $request, Department $department)
    {
        $validated=$this->validate($request, [
            'id' => ['required', Rule::exists('users')]
        ]);
        $department->users()->sync([$validated['id']]);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Department user added successfully'
        ]);

        return back();
    }

    public function detachDepartmentUser(Request $request, Department $department, int $user)
    {
        $department->users()->detach([$user]);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Department user detached successfully'
        ]);

        return back();
    }
}
