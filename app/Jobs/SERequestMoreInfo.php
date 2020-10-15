<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\FLRequestMoreInfoMailable;
use Mail;

class SERequestMoreInfo implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $info;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $info) {
        $this->email = $email;
        $this->name = $name;
        $this->info = $info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->email)->queue(new FLRequestMoreInfoMailable($this->email, $this->name, $this->info));
    }
}
