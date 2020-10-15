<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestRevisionMailable extends Mailable {
    use Queueable, SerializesModels;

    public $email;
    public $link;
    public $note;
    public $percentage;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.request-revision')
            ->subject("Homework Solution Revision")
            ->with([
               'link' => $this->link,
                'note'=> $this->note,
                'percentage'=>$this->percentage,

           ]);
    }
}
