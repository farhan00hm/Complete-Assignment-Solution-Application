<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FLHiredMailable extends Mailable {
    use Queueable, SerializesModels;

    public $hwUuid;
    public $hwTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hwUuid, $hwTitle) {
        $this->hwUuid = $hwUuid;
        $this->hwTitle = $hwTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.fl-hired')
            ->subject("You have been hired!")
            ->with([
                'hwUuid' => $this->hwUuid,
                'hwTitle' => $this->hwTitle,
           ]);
    }
}
