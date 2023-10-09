<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\BankVerification;
use App\Utils\BankAvManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Backend/Bank/Index',[
            'list'=>BankVerification::query()->with(['user'])->latest()->get()
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/Bank/Create');
    }

    public function verify(Request $request)
    {
        $offset = $request->get('from', 0);
        $limit = $request->get('to', 10);

        $applications=Application::query()
            ->with(['bankAccount'])
            ->whereIn('status', ['submitted'])
            ->offset($offset)
            ->limit($limit)
            ->get();


        $av=BankVerification::query()->create([
            'user_id'=>auth()->id(),
            'path'=>null,
            'offset'=>$offset,
            'limit'=>$limit,
            'remark'=>null,
        ]);
        $avManager=new BankAvManager($av,$applications);
        $fileName = $avManager->generateInpFileName();
        $resName = $avManager->generateResFileName();
        $inpPath=Storage::disk('public')->put("av/$fileName",$avManager->toString());
        $resPath=Storage::disk('public')->put("av/$resName",$avManager->toString());

        $av->res_path = "av/$fileName";
        $av->inp_path = "av/$resName";
        $av->save();

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'AV File created successfully'
        ]);

        return back();

    }



}
