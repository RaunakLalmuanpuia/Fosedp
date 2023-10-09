<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OutgoingApplicationController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->get('search');
        $perPage = $request->get('per_page') ?? 15;

        $list=Application::query()
            ->with(['district','constituency','trade','department','subTrade'])
            ->when($search,fn(Builder $builder)=>$builder->where('head_of_family','LIKE',"$search%"))
            ->whereHas('lastMovement', fn(Builder $builder) => $builder->where('sender_id',auth()->id())->whereNull('received_at'))
            ->paginate($perPage);
        return inertia('Backend/Application/Outgoing/Index', [
            'search'=>$search,
            'list' => $list,
        ]);
    }
}
