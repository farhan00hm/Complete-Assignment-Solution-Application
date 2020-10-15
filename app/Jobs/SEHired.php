<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\FLHiredMailable;
use Mail;

class SEHired implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $hwUuid;
    protected $hwTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $hwUuid, $hwTitle) {
        $this->email = $email;
        $this->hwUuid = $hwUuid;
        $this->hwTitle = $hwTitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->email)->queue(new FLHiredMailable($this->hwUuid, $this->hwTitle));
    }
}
