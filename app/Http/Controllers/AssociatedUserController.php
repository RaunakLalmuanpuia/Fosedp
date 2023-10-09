<?php

namespace App\Http\Controllers;

use App\Models\AssociatedUser;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;

class AssociatedUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return inertia('Backend/AssociatedUser/Index', [
            'list' => AssociatedUser::query()
                ->with(['parent','user','district'])
               ->paginate(),
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/AssociatedUser/Create', [
            'users'=>User::query()
                ->whereNot('id',auth()->id())
                ->get(['id as value','name as label']),
            'districts'=>District::query()->get(['id as value','name as label'])
        ]);
    }
    public function store(Request $request)
    {
        $validatedData=$this->validate($request, [
            'parent_id'=>'required',
            'user_id'=>'required',
            'district_id'=>'required'
        ]);
        $data=AssociatedUser::query()->create($validatedData);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Associated User Created successfully'
        ]);

        return to_route('associated-user.index');
    }

    public function update(Request $request, AssociatedUser $associatedUser)
    {

    }

    public function destroy(Request $request, AssociatedUser $associatedUser)
    {
        $associatedUser->delete();

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'User created successfully'
        ]);
        return to_route('associated-user.index');
    }
}
