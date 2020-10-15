<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FLCounterOfferMailable extends Mailable {
    use Queueable, SerializesModels;

    public $bidUuid;
    public $hwUuid;
    public $hwTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bidUuid, $hwUuid, $hwTitle) {
        $this->bidUuid = $bidUuid;
        $this->hwUuid = $hwUuid;
        $this->hwTitle = $hwTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.fl-counteroffer')
            ->subject("Bid Counter Offer")
            ->with([
                'bidUuid' => $this->bidUuid,
                'hwUuid' => $this->hwUuid,
                'hwTitle' => $this->hwTitle,
           ]);
    }
}
