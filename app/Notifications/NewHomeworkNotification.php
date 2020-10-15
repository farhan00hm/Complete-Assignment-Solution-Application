<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHomeworkNotification extends Notification
{
    use Queueable;

//    protected $email;
//    protected $name;
    protected $hwUuid;
    protected $hwTitle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($hwUuid, $hwTitle)
    {
//        $this->email = $email;
//        $this->name = $name;
        $this->hwUuid = $hwUuid;
        $this->hwTitle = $hwTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            "hwUuid"=>$this->hwUuid,
            "hwTitle"=>$this->hwTitle
        ];
    }
}
