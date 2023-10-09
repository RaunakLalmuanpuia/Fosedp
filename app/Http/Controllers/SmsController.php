<?php

namespace App\Http\Controllers;

use App\Jobs\SmsJob;
use App\Models\Application;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send(Request $request,int $offset,int $limit){
        info('info---limit '.$limit);
        $applications=Application::query()->offset($offset)->limit($limit)->get();
        foreach ($applications as $application) {
            $job = new SmsJob($application->mobile);
            $this->dispatch($job->delay(30));
        }

        return response()->noContent();
    }
}
