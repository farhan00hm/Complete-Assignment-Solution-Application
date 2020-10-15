<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\StudentHomeworkSolutionApprovedMailable;
use Mail;

class StudentHomeworkSolutionApproved implements ShouldQueue {
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
        Mail::to($this->email)->queue(new StudentHomeworkSolutionApprovedMailable($this->email,$this->link));
    }
}
