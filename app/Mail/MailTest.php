<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTest extends Mailable
{
    use Queueable, SerializesModels;

    private $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($time)
    {
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return MailTest
     */
    public function build(): MailTest
    {
        $subject = 'This eMailTest is a demo! ';
        $address = 'pardeepkumar@example.com';
        $name = 'Jane Doe';

        return $this->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject . $this->time)
                    ->tag($this->time)
                    ->markdown('welcome');
    }
}
