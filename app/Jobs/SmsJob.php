<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $mobile;

    /**
     * Create a new job instance.
     *
     * @param string $mobile
     */
    public function __construct(string $mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $templateId = '1407168049909542011';
        $message = "Family Oriented SEDP hnuaia i dilna hi thehluh tawh a ni e. -P&PID(RDB)";
        $response=Http::withHeaders([
            'Authorization' => "Bearer " . env('SMS_TOKEN','401|Vp8GHtZVTwfahqbHqzP36b94XSGvWGh6oC6p2KjO'),
        ])->get("https://sms.msegs.in/api/send-sms",[
            'template_id' => $templateId,
            'message' => $message,
            'recipient'=>$this->mobile
        ]);
        info("SMS response ".$response->body());

    }
}
