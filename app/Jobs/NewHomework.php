<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NewHomeworkMailable;
use Mail;

class NewHomework implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $hwUuid;
    protected $hwTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $hwUuid, $hwTitle) {
        $this->email = $email;
        $this->name = $name;
        $this->hwUuid = $hwUuid;
        $this->hwTitle = $hwTitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->email)->queue(new NewHomeworkMailable($this->name, $this->hwUuid, $this->hwTitle));
    }
}
