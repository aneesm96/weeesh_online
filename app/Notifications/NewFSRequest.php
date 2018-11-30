<?php

namespace Weeesh\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewFSRequest extends Notification
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

        $up_by = $this->fs_request->user_profile_by;
        $subject = $up_by->name." ".$up_by->surname." ".
            __("wants become your friend on Weeesh.com!");

        $introduction = $subject;

        $url = url('/user_profiles?search='.$up_by->name);


        return (new MailMessage)
                    ->subject($subject)
                    ->line($introduction)
                    ->action( __("View on Weeesh"), url($url))
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
