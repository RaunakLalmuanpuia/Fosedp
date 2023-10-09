<?php

namespace App\Jobs;

use App\Models\ExportReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $applications;
    private ExportReport $exportReport;
    public $timeout = 420;


    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $applications
     * @param ExportReport $report
     */
    public function __construct($user,$applications,ExportReport $report)
    {
        $this->user = $user;
        $this->applications = $applications;
        $this->exportReport = $report;
//        $this->onQueue('export');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $path = "report/" . $this->user->name . 'report_created_on' . now()->timestamp.'.xlsx';
        $writer = SimpleExcelWriter::create(storage_path("app/public/$path"));

        $writer->addHeader(['head_of_family','mobile','epic_no','district','constituency','address','department','trade','sub_trade']);
        $this->applications->map(function ($application,$i) use ($writer) {
            $writer->addRow([
                'head_of_family' => $application?->head_of_family,
                'mobile' => $application?->mobile,
                'epic_no'=>$application?->epic_no,
                'district'=>$application?->district?->name,
                'constituency'=>$application?->constituency?->name,
                'address'=>$application?->address,
                'department'=>$application?->department?->name,
                'trade'=>$application?->trade?->name,
                'sub_trade'=>$application?->sub_trade?->name,
            ]);
            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
        });
        $this->exportReport->path = $path;
        $this->exportReport->status = 'generated';
        $this->exportReport->save();

//        $export=new ExportApplications($this->applications);

//        $export->store($path,'public');



    }

}
