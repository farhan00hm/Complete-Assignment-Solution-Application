<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyPaymentReceiptMailable extends Mailable {
    use Queueable, SerializesModels;

    public $name;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $link) {
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.weekly-payment-receipt')
            ->subject("Payment Receipt")
            ->with([
               'name' => $this->name,
               'link' => $this->link,
           ]);
    }
}
