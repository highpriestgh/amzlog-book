<?php
namespace App\Helpers;

use App\Mail\Mailer;

class CustomMailer
{
    public function sendMail(string $email, string $subject, string $title, string $salutation, string $text)
    {
        $mailData = array('subject' => $subject, 'title' => $title, 'salutation' => $salutation, 'text' => $text);
        \Mail::to($email)->send(new Mailer($mailData));
    }
}
