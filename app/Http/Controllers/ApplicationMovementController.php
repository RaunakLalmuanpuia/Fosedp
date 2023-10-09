<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ApplicationMovementController extends Controller
{
    public function revert(Request $request,Application $model)
    {
        $model->lastMovement()->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application Pull Back Successfully'
        ]);
        return to_route('application.received');
    }

    public function bulkRevert(Request $request)
    {
        $data=$this->validate($request, [
            'ids' => 'required'
        ]);
        DB::transaction(function () use ($data) {
            foreach($data['ids'] as $id) {
                $application = Application::query()->findOrFail($id);
                if ($application->applicationMovements()->count() > 1) {
                    $application->lastMovement()->delete();
                }

            }
        });
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>count($data['ids'])." Application Revert Back Successfully"
        ]);
        return redirect()->back();

    }

    public function take(Request $request,Application $model)
    {
        $model->lastMovement()->update([
            'received_at' => now(),
            'recipient_id'=>auth()->id()
        ]);
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application Taken Successfully'
        ]);
        return to_route('application.received');
    }

    public function forward(Request $request)
    {
        $validatedData=$this->validate($request, [
            'ids'=>['required',Rule::exists('applications','id')],
            'user_id'=>['required',Rule::exists('users','id')],
        ]);

        $remark = $request->get('remark') ?? '';
        $data=collect($validatedData['ids'])
            ->map(function ($id) use ($remark, $validatedData) {
                return [
                    'application_id' => $id,
                    'sender_id' => auth()->id(),
                    'recipient_id' => $validatedData['user_id'],
                    'received_at' => null,
                    'sent_at' => now(),
                    'type' => ApplicationMovement::INSIDE,
                    'remark' => $remark
                ];
            })->toArray();

        ApplicationMovement::query()->insert( $data);
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Application forwarded successfully'
        ]);
        return redirect()->back();


    }
}
