<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTest extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $subject = 'This eMailTest is a demo! ')
    {
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return MailTest
     */
    public function build(): MailTest
    {
        $address = 'email@example.com';
        $name = 'Test eMail';

        return $this->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($this->subject)
//                    ->tag($this->time)
                    ->markdown('welcome');
    }
}
