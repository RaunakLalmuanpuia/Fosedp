<?php

namespace App\Http\Controllers;

use App\Models\Constituency;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page') ?? 15;
        return inertia('Backend/District/Index', [
            'list' => District::query()->latest()->paginate($perPage),
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Backend/District/Create');
    }
    public function store(Request $request)
    {
        $data=$this->validate($request, [
            'name' => 'required',
            'code'=>'required'
        ]);
        District::query()->create($data);

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'District created successfully'
        ]);

        return to_route('district.index');
    }

    public function edit(Request $request,District $district)
    {
        return inertia('Backend/District/Edit', [
            'data' => $district->load(['constituencies']),
        ]);
    }

    public function update(Request $request,District $district)
    {
        $data=$this->validate($request, [
            'name' => 'required',
            'code'=>'required'
        ]);

        $district->update($data);
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'District updated successfully'
        ]);
        return to_route('district.index');
    }

    public function destroy(Request $request, District $district)
    {
        $district->delete();
        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'District deleted successfully'
        ]);

        return to_route('district.index');
    }


}
