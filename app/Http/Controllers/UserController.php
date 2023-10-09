<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->integer('per_page', 15);
        return inertia('Backend/User/Index', [
            'list' => User::query()
                ->when($search,fn(Builder $builder)=>$builder->where('name','LIKE',"%$search%"))
                ->with(['roles','departments'])
                ->paginate($perPage),
            'search' => $search ?? '',
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/User/Create', [
            'districts' => District::query()->get(['id as value','name as label']),
            'roles' => Role::query()->get(['id as value','name as label'])
        ]);
    }

    public function store(Request $request)
    {
        $validated=$this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'password'=>'required|confirmed',
            'role_ids'=>['required',Rule::exists('roles','id')],
        ]);
        DB::transaction(function () use ($request, $validated) {
            $user = new User($validated);
            $user->password = Hash::make($validated['password']);
            $user->save();
            $user->roles()->sync($validated['role_ids']);
            if ($request->has('ids')) {
                $user->districts()->sync($request['ids']);
            }
            return $user;
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'User created successfully'
        ]);

        return to_route('user.index');

    }

    public function edit(Request $request,User $user)
    {
        return inertia('Backend/User/Edit', [
            'districts' => District::query()->get(['id as value','name as label']),
            'roles' => Role::query()->get(['id as value','name as label']),
            'data' => $user->load(['roles','districts']),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated=$this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'role_ids'=>['required',Rule::exists('roles','id')],
        ]);
        DB::transaction(function () use ($request, $validated, $user) {
            $user->update($validated);
            $user->roles()->sync($validated['role_ids']);
            if ($request->has('ids')) {
                $user->districts()->sync($request['ids']);
            }
            $password = $request->get('password');
            if (filled($password)) {
                $user->password = Hash::make($password);
            }
            $user->save();
        });

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'User updated successfully'
        ]);

        return to_route('user.index');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'User deleted successfully'
        ]);
        return redirect(route('user.index'));
    }
}
