<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\RequestRevisionMailable;
use Mail;

class RequestRevision implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $link;
    protected $note;
    protected $percentage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $link,$note,$percentage) {
        $this->email = $email;
        $this->link = $link;
        $this->note = $note;
        $this->percentage = $percentage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->email)->queue(new RequestRevisionMailable($this->email,$this->link,$this->note,$this->percentage));
    }
}
