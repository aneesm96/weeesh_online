<?php

/**
 * @author: Francesco
 * @date: 07/01/18
 * @time: 11:10
 *
 * @rif:https://scotch.io/tutorials/ultimate-guide-on-sending-email-in-laravel
 *
 */
namespace Weeesh\Http\Controllers;

use Illuminate\Http\Request;
use Weeesh\Mail\MailMessage;

class EmailController extends Controller
{
    //
    public function send(MailMessage $message){
        \Mail::send($message);
        return back();
    }

}

