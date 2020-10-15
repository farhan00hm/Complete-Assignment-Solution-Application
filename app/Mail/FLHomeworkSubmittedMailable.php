<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FLHomeworkSubmittedMailable extends Mailable {
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
        return $this->view('emails.fl-homework-submitted')
            ->subject("Homework Solution Submitted")
            ->with([
               'link' => $this->link
           ]);
    }
}
