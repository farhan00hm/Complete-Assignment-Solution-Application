<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FLHomeworkSolutionApprovedMailable extends Mailable {
    use Queueable, SerializesModels;

    public $email;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $link) {
        $this->email = $email;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.fl-homework-approved')
            ->subject("Homework Approved")
            ->with([
               'link' => $this->link,
           ]);
    }
}
