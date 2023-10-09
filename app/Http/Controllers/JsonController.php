<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationMovement;
use App\Models\User;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function movementHistory(Request $request,Application $model)
    {
        $list = ApplicationMovement::query()->where('application_id',$model->id)->get();
        return [
            'list'=>$list
        ];
    }

    public function userPerms(Request $request, User $user)
    {
        dd($user);
    }
}
