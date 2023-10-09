<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    public function index(Request $request)
    {

        return inertia('Backend/Notice/Index', [
            'list' => Notice::query()->simplePaginate(),
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/Notice/Create', [

        ]);
    }

    public function edit(Request $request,Notice $notice)
    {
        return inertia('Backend/Notice/Edit', [
            'data' => $notice
        ]);
    }
    public function store(Request $request)
    {
        $data=$this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'published'=>'required|boolean',
        ]);
        Notice::query()->create(array_merge($data,[
            'slug'=>Str::slug($data['title'])
        ]));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Notice created successfully'
        ]);
        return to_route('notice.index');
    }
    public function update(Request $request,Notice $notice)
    {
        $data=$this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'published'=>'required|boolean',
        ]);
        $notice->update(array_merge($data,[
            'slug'=>Str::slug($data['title'])
        ]));
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Notice updated successfully'
        ]);
        return to_route('notice.index');
    }

    public function destroy(Request $request,Notice $notice)
    {
        $notice->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Notice deleted successfully'
        ]);

        return to_route('notice.index');
    }
}
