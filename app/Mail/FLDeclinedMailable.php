<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FLDeclinedMailable extends Mailable {
    use Queueable, SerializesModels;

    public $email;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name) {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.declined')
            ->subject("Freelancer Application Declined")
            ->with([
               'email' => $this->email,
               'name' => $this->name,
           ]);
    }
}
