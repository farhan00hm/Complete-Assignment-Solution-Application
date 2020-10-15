<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WeeklyPaymentsMailable;
use Mail;

class WeeklyPayment implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;
    protected $filePath;
    protected $to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $fileName, $filePath) {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->to)->queue(new WeeklyPaymentsMailable($this->fileName, $this->filePath));
    }
}
