<?php

namespace App\Http\Controllers;

use App\Models\AssociatedUser;
use App\Models\Department;
use App\Models\District;
use App\Models\Role;
use App\Models\SubTrade;
use App\Models\Trade;
use App\Models\User;
use App\Models\UserDistrict;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function constituencies(Request $request,District $district): JsonResponse
    {
        $list=$district->constituencies()->get(['id as value','name as label']);
        return response()->json([
            'list'=>$list
        ]);
    }

    public function trades(Request $request): JsonResponse
    {
        $search = $request->get('search') ?? false;
        $list=Trade::query()
            ->when(filled($search),fn(Builder $builder)=>$builder->where('name','LIKE',"%$search%"))
            ->get(['id as value','name as label','department_id']);
        return response()->json([
            'list'=>$list
        ]);
    }

    public function departmentTrades(Request $request,Department $department): JsonResponse
    {
        $list=$department->trades()->get(['id as value','name as label']);
        return response()->json([
            'list'=>$list
        ]);
    }

    public function subTrades(Request $request, Trade $trade)
    {
        $list=$trade->subTrades()->get(['id as value', 'name as label']);
        return response()->json([
            'list'=>$list
        ]);
    }

    public function executiveUsers(Request $request)
    {
        $list=User::query()
            ->whereHas('roles', fn(Builder $builder) => $builder->where('name', 'executive'))
            ->get(['id as value', 'name as label']);
        return response()->json([
            'list' => $list
        ]);
    }
    public function departmentUsers(Request $request)
    {
        $list=User::query()
            ->whereHas('roles', fn(Builder $builder) => $builder->where('name', 'department'))
            ->get(['id as value', 'name as label']);
        return response()->json([
            'list' => $list
        ]);
    }

    public function planningUsers(Request $request)
    {
        $list=User::query()
            ->whereHas('roles', fn(Builder $builder) => $builder->where('name', 'planning'))
            ->get(['id as value', 'name as label']);
        return response()->json([
            'list' => $list
        ]);
    }
    public function dcUsers(Request $request)
    {
        $district_ids = UserDistrict::query()->where('user_id',auth()->id())->pluck('district_id');
        $list=User::query()
            ->whereHas('districts', fn(Builder $builder) => $builder->whereIn('districts.id', $district_ids))
            ->whereHas('roles', fn(Builder $builder) => $builder->where('name', 'dc'))
            ->get(['id as value', 'name as label','remark']);
        return response()->json([
            'list' => $list
        ]);
    }
    public function dcVerifiers(Request $request)
    {
        $district_ids = UserDistrict::query()->where('user_id',auth()->id())->pluck('district_id');
        $list=User::query()
            ->whereHas('districts', fn(Builder $builder) => $builder->whereIn('districts.id', $district_ids))
            ->whereHas('roles', fn(Builder $builder) => $builder->where('name', 'dc-verifier'))
            ->get(['id as value', 'name as label','remark']);
        return response()->json([
            'list' => $list
        ]);
    }
    public function dcApprovals(Request $request)
    {
        $district_ids = UserDistrict::query()->where('user_id',auth()->id())->pluck('district_id');
        $list=User::query()
            ->whereHas('districts', fn(Builder $builder) => $builder->whereIn('districts.id', $district_ids))
            ->whereHas('roles', fn(Builder $builder) => $builder->where('name', 'dc-approval'))
            ->get(['id as value', 'name as label','remark']);
        return response()->json([
            'list' => $list
        ]);
    }

    public function associatedUsers(Request $request)
    {

        $ids=AssociatedUser::query()->where('parent_id', auth()->id())->pluck('user_id');
        $list=User::query()
            ->whereIn('id',$ids)
            ->get(['id as value','name as label','remark']);

        return response()->json([
            'list' => $list
        ]);
    }
    public function users(Request $request)
    {
        $seach = $request->get('search');
        $list=User::query()
            ->get(['id as value', 'name as label']);
        return response()->json([
            'list' => $list
        ]);
    }
}
