<?php

namespace App\Http\Controllers;

use App\Models\AssociatedUser;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Testing\Concerns\Has;

class TaskGroupController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Backend/TaskGroupUser/Index', [
            'list' => AssociatedUser::query()
                ->with(['user'])
                ->where('parent_id', auth()->id())->paginate(),
        ]);
    }
    public function create(Request $request)
    {
        return inertia('Backend/TaskGroupUser/Create', [
            'districts'=>District::query()->get(['id as value','name as label'])
        ]);
    }

    public function store(Request $request)
    {
        $validated=$this->validate($request, [
            'name' => 'required',
            'mobile' => ['required',Rule::unique('users','mobile')],
            'email' => 'required|email',
            'password'=>'required|confirmed',
        ]);
        DB::transaction(function () use ($request, $validated) {
            $user = new User($validated);
            $user->password = Hash::make($validated['password']);
            $user->save();
            $user->assignRole('office');

            AssociatedUser::query()->create([
                'parent_id' => auth()->id(),
                'user_id'=>$user->id,
                'district_id'=>$request->get('district_id')
            ]);
            return $user;
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Task Group User created successfully'
        ]);

        return to_route('task-group-user.index');
    }
    public function edit(Request $request, AssociatedUser $user)
    {
        return inertia('Backend/TaskGroupUser/Edit', [
            'user'=>$user->user,
            'data'=>$user,
            'district'=>$user->district,
            'districts'=>District::query()->get(['id as value','name as label'])
        ]);
    }

    public function update(Request $request, AssociatedUser $user)
    {
        $validated=$this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
        ]);
        $taskUser = $user->user;
        $taskUser->update($validated);
        if ($request->has('district_id')) {
            $user->district_id = $request->get('district_id');
            $user->save();
        }
        if ($request->has('password')) {
            $taskUser->password = Hash::make($request->get('password'));
            $taskUser->save();
        }
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Task Group User Updated successfully'
        ]);

        return to_route('task-group-user.index');

    }

    public function destroy(Request $request, AssociatedUser $user)
    {
        DB::transaction(function () use ($user) {
            $user->user()->delete();
            $user->delete();
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Task Group User Deleted Successfully'
        ]);

        return to_route('task-group-user.index');
    }

}
