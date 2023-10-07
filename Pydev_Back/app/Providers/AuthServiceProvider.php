<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\DevisPolicy;
use App\Policies\OffrePolicy;
use Laravel\Passport\Passport;
use App\Models\Affreteur\Offre;
use App\Models\Transporteur\Devis;
use App\Policies\MoyenTransportPolicy;
use App\Models\Transporteur\MoyenTransport;
use App\Policies\TransporteurInternePolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Transporteur\Societe\TransporteurInterne;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Offre::class => OffrePolicy::class,
        MoyenTransport::class => MoyenTransportPolicy::class,
        TransporteurInterne::class => TransporteurInternePolicy::class,
        Plainte::class => PlaintePolicy::class,
        Devis::class => DevisPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $user = User::whereId($notifiable->getKey())->first();
            return (new MailMessage)->view('emails.registration', ['user' => $user, 'url' => $url])->subject('Confirmation de compte');
        });


        Passport::routes();
        Passport::tokensExpireIn(now()->addMonths(1));
        Passport::refreshTokensExpireIn(now()->addMonths(1));
        Passport::personalAccessTokensExpireIn(now()->addMonths(1));
        Passport::tokensCan([
            'user' => 'Accès aux modules réservés au rôle administrateur ',
            'client' => 'Accès aux modules réservés au rôle client',
        ]);
    }
}
