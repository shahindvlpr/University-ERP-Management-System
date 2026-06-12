<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class StudentWelcomeMail extends Mailable
{
    public $name;
    public $email;
    public $password;

    public function __construct(
        $name,
        $email,
        $password
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this
            ->subject('University ERP Login Account')
            ->view('emails.student_welcome');
    }
}