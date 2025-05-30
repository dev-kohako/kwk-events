<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Mjml\Mjml;

class VerifyEmailMJML extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $url, public $user) {}

    public function build()
    {
        $mjml = Mjml::new();

        $mjmlView = view('emails.verify-email', [
            'url' => $this->url,
            'user' => $this->user,
        ])->render();

        return $this->subject('Confirme seu e-mail')
                    ->html($mjml->toHtml($mjmlView));
    }
}
