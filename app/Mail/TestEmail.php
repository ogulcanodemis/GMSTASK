<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function build()
    {
        return $this->view('emails')
            ->subject('Test E-postası');
    }
}
