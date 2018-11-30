<?php

namespace Weeesh\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FSRequestDenied extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fs_request)
    {
        $this->fs_request = $fs_request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable){

        $up_to= $this->fs_request->user_profile_to;
        $subject = $up_to->name." ".$up_to->surname." ".
            __("doesn't want become your friend on Weeesh.com!");

        $introduction = $subject;

        $url = url('/user_profiles?search=');


        return (new MailMessage)
                    ->subject($subject)
                    ->line($introduction)
                    ->action( __("Find new friends on Weeesh"), url($url))
                    ->line(__('Thank you!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => __('A new Friend Request on Weeesh'),
            'action' => url($this->fs_request->id_user_profile_by)
        ];
    }
}
