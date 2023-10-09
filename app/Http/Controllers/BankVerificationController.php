<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class BankVerificationController extends Controller
{
    public function create(Request $request)
    {
        return inertia('Backend/Bank/Verification/Create');
    }

    public function generate(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);

        dd('offset' . $offset . PHP_EOL . 'Limit' . $limit);
        $applications=Application::query()
            ->offset($offset)
            ->limit($limit)
            ->get();

        dd($applications);
    }

}
