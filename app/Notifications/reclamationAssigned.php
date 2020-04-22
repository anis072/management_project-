<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class reclamationAssigned extends Notification
{
    use Queueable;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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
        ->line('New Reclamation about  '. $this->data['projet'] .' project')
        ->action('Notification Action', url('/detailleReclamation/'.$this->data['id']))
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
            'idrec' => $this->data['id'],
            'type' => $this->data['type'],
            'projet' => $this->data['projet'],
            'typeNotification' => 'App\Notifications\reclamationAssigned'
        ];

    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'idrec' => $this->data['id'],
            'type' => $this->data['type'],
                'projet' => $this->data['projet'],
                'user' => auth()->user(),
                'typeNotification' => 'App\Notifications\reclamationAssigned'
        ]);
    }
}
