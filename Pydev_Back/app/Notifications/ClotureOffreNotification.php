<?php

namespace App\Notifications;

use App\Models\Affreteur\Offre;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClotureOffreNotification extends Notification implements ShouldQueue 
{
    use Queueable;
    protected $offre;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Offre $offre)
    {
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
        $content = "Cette offre de frêt " . $this->offre->code . ' est clôturée par ' . $this->offre->affreteur->lastname . ' ' . $this->offre->affreteur->firstname;
        return [
            'title' => 'Clôture d\'offre de frêt',
            'subtitle' => $content,
            'offre' =>  $this->offre,
            'type' =>  'light-info',


        ];
    }
}
