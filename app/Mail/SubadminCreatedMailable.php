<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubadminCreatedMailable extends Mailable {
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $password;
    public $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $password, $role) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.subadmin-created')
            ->subject("System Access Credentials")
            ->with([
               'name' => $this->name,
               'email' => $this->email,
               'password' => $this->password,
               'role' => $this->role,
           ]);
    }
}
