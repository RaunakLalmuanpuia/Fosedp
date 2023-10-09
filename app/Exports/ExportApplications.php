<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ExportApplications implements FromView,WithChunkReading
{
    use Exportable;
    private $applications;

    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    public function view(): View
    {
        return view('exports.received-application', [
            'applications' => $this->applications
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
