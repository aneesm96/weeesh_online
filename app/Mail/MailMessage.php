<?php

/**
 *
 * Author: Francesco
 * @date: 07/01/18
 * @time: 11:40
 *
 * @rif: https://scotch.io/tutorials/easy-and-fast-emails-with-laravel-5-3-mailables
 *
 */
namespace Weeesh\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailMessage extends Mailable
{
    use Queueable, SerializesModels;


    public $address = "";


    public $view    = "email.message";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //Modifico headers per cercare di non andare nello SPAM

        //https://stackoverflow.com/questions/41515982/laravel-mailable-headers
        //$headers = 'From: YourLogoName info@domain.com' . "\r\n" ;
        //$headers .='Reply-To: '. $to . "\r\n" ;
        //$headers .='X-Mailer: PHP/' . phpversion();
        //$headers .= "MIME-Version: 1.0\r\n";
        //$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        $this->withSwiftMessage(function ($message) {
            $headers = $message->getHeaders();
            //$headers->addTextHeader('From', 'Weeesh.com! notification@weeesh.com');
            $headers->addTextHeader('Reply-To', 'notification@weeesh.com');
            $headers->addTextHeader('X-Mailer', "PHP/" . phpversion());
            //$headers->addTextHeader('MIME-Version', '1.0');
            //$headers->addTextHeader('Content-type', 'text/html; charset=iso-8859-1');

            //dd($headers);
        });



        return $this->view($this->view)
            ->setAddress($this->address)
            ->with("name_from",$this->name_from)
            ->with("name_to", $this->name_to)
            ->bcc("gallomaf@libero.it")
            ->subject($this->subject);
    }
}
