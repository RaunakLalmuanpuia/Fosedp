<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\Trade;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function departmentTrade(Request $request)
    {
        $departments=Department::query()->withCount('applications')->get();

        return [
            'list' => $departments
        ];
    }

    public function constituencyApplications(Request $request)
    {
        $wise = $request->get('toggle') ?? 'district';
        $constituenciesCount=Constituency::query()->withCount('applications')->get();
        $districtCount = District::query()->withCount('applications')->get();
        return [
            'list' => $wise ==='district' ?$districtCount : $constituenciesCount
        ];
    }

    public function tradeDistrictWise(Request $request)
    {
        $districts=District::query()->get();
        $trades=Trade::query()->get();

        $tradeData=$trades->map(function (Trade $trade) use ($districts) {
            $application_counts = [];
            foreach ($districts as $district) {
                $count=Application::query()->where('trade_id', $trade->id)
                    ->where('district_id',$district->id)
                    ->count();
                array_push($application_counts, [
                    'district_id' => $district->id,
                    'application_count' => $count
                ]);
            }

            $trade['app_data'] = $application_counts;
            return $trade;
        });


        return [
            'districts' => $districts,
            'trades'=>$tradeData
        ];
    }
}
