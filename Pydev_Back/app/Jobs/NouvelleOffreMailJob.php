<?php

namespace App\Jobs;

use App\Mail\NouvelleOffreMail;
use App\Models\Affreteur\Offre;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NouvelleOffreMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $offre;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Offre $offre)
    {
        $this->user = $user;
        $this->offre = $offre;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $offre = $this->offre;
        Mail::to($this->user->email)->send(new NouvelleOffreMail($user, $offre));
    }
}
