<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WeeklyPaymentReceiptMailable;
use Mail;

class WeeklyPaymentReceipt implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $link;
    protected $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $link, $name) {
        $this->email = $email;
        $this->link = $link;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->email)->queue(new WeeklyPaymentReceiptMailable($this->name, $this->link));
    }
}
