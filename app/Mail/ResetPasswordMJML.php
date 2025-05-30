<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Mjml\Mjml;

class ResetPasswordMJML extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $token, public string $email, public $user) {}

    public function build()
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ], false));

        $mjml = Mjml::new();

        $mjmlView = view('emails.reset-password', [
            'url' => $url,
            'user' => $this->user,
        ])->render();

        return $this->subject('Redefina sua senha')
                    ->html($mjml->toHtml($mjmlView));
    }
}
