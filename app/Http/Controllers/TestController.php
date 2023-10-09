<?php

namespace App\Http\Controllers;

use App\Jobs\SmsJob;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testQueue(Request $request, $mobile)
    {
        $this->dispatch(new SmsJob($mobile));
    }
}
