<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewHomeworkMailable extends Mailable {
    use Queueable, SerializesModels;

    public $name;
    public $hwUuid;
    public $hwTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $hwUuid, $hwTitle) {
        $this->name = $name;
        $this->hwUuid = $hwUuid;
        $this->hwTitle = $hwTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.new-homework')
            ->subject("New Homework")
            ->with([
                'name' => $this->name,
                'hwUuid' => $this->hwUuid,
                'hwTitle' => $this->hwTitle,
           ]);
    }
}
