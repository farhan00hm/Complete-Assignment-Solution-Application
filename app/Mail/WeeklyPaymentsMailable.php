<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyPaymentsMailable extends Mailable {
    use Queueable, SerializesModels;

    public $fileName;
    public $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fileName, $filePath) {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.weekly-payments')
            ->subject("Freelancer Weekly Payments File")
            ->attachFromStorageDisk('s3', $this->filePath, $this->fileName)
            ->with([
               'fileName' => $this->fileName,
               'filePath' => $this->filePath,
           ]);
    }
}
