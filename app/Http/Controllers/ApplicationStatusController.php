<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    public function updateStatus(Request $request, Application $model)
    {
        $model->currentStatus()->update([
            'name'=>$request->get('status'),
            'user_id' => auth()->id(),
        ]);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application status updated successfully'
        ]);

        return back();
    }
}
