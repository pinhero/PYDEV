<?php

namespace App\Mail;

use App\Models\Affreteur\Offre;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleOffreMail extends Mailable
{
    use Queueable, SerializesModels;
    public $offre;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( User $user,Offre $offre)
    {
        $this->user = $user;
        $this->offre = $offre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.offer_notification')->with(['offre' => $this->offre, 'user' => $this->user])->from('e-signature@mameribj.org')->subject('Publication d\'offre de fret');

    }
}
