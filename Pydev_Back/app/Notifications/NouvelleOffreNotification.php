<?php

namespace App\Notifications;

use App\Models\Affreteur\Offre;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleOffreNotification extends Notification implements ShouldQueue 
{
    use Queueable;

    protected $offre;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Offre $offre)
    {
        $this->user = $user;
        $this->offre = $offre;
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
        $content = "Nouvelle offre de frêt " . $this->offre->code . ' ajoutée par ' . $this->offre->affreteur->lastname.' '.$this->offre->affreteur->firstname;
        return [
            'title'=> 'Publication d\'offre de frêt',
            'subtitle'=> $content,
            'user' =>  $this->user ,
            'offre' =>  $this->offre ,
            'type' =>  'light-info' ,


        ];
    }
}
