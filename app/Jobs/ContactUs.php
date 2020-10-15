<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ContactUsMailable;
use Mail;

class ContactUs implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $subject;
    protected $comments;
    protected $adminEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $subject, $comments, $adminEmail) {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->comments = $comments;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->adminEmail)->queue(new ContactUsMailable($this->name, $this->email, $this->subject, $this->comments));
    }
}
