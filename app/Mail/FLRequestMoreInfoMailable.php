<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FLRequestMoreInfoMailable extends Mailable {
    use Queueable, SerializesModels;

    public $email;
    public $name;
    public $info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $info) {
        $this->email = $email;
        $this->name = $name;
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.request-info')
            ->subject("Freelancer - Provide More Information")
            ->with([
               'email' => $this->email,
               'name' => $this->name,
               'info' => $this->info,
           ]);
    }
}
