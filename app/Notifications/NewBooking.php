<?php

namespace Weeesh\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Weeesh\ListRow;

class NewBooking extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
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

        $list_row = ListRow::find($this->booking->id_list_row);

        $subject = $list_row->object . " ".  __("has been booked on your Weeesh.com!");

        $introduction = $subject;

        //devo recuperare l'id della lista
        //http://127.0.0.1/edsa-weeesh.com/public/index.php/wlists/22

        $url = url('/wlists/'.$list_row->id_list);


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
