<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\FLHomeworkSubmittedMailable;
use Mail;

class SEHomeworkSubmitted implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $link) {
        $this->email = $email;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        Mail::to($this->email)->queue(new FLHomeworkSubmittedMailable($this->link));

    }
}
