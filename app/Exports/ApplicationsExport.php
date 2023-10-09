<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicationsExport implements FromView
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function view(): View
    {
        return view('exports.received-application', [
            'applications' => Application::query()
                ->with(['district','constituency','trade','department','subTrade','currentStatus'])
                ->whereHas('lastMovement', fn(Builder $builder) => $builder->where('recipient_id',$this->userId)->whereNotNull('received_at'))
                ->get()
        ]);
    }
}
