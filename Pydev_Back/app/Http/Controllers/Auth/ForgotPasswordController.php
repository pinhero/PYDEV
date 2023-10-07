<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\ResetPasswordMailJob;
use App\Http\Controllers\BaseController;
use App\Models\Auth\UserConfirmationToken;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends BaseController
{
    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $email = $request->email;
        $user = User::where('email', $email)->first();

        // Vérifier si l'adresse mail existe dans notre base de données
        if (!$user) {
            return $this->sendError('Cette adresse mail n\'existe pas.');
        }
        //Create UserConfirmationTokenInfo
        $token = uniqid();
        $url = 'https://pebco.mameribj.org';
        $userConfirmToken =  UserConfirmationToken::create([
            'user_id' => $user->id,
            'callback_url' => $url,
            'email' => $request->email,
            'url' => $url . '/reset-password/' . $token,
            'date_expiration' => now()->addMinutes(30),
            'token' => $token,
            'deja_utilise' => false,
        ]);
        $url = $userConfirmToken->url;


        // Send Mail
        ResetPasswordMailJob::dispatch($user,$url);
        return $this->sendResponse([], 'Veuillez vérifier votre mail, pour réinitiliser votre mot de passe.');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $token = $request->token;
        $passwordRest = UserConfirmationToken::whereToken($token)->first();

        // Vérifier si le token existe
        if (!$passwordRest) {
            return $this->sendError('Token n\'existe pas.');
        }

        // Verifier si le token est déjà utilisé
        if ($passwordRest->deja_utilise) {
            return $this->sendError('Token déjà utilisé.');
        }

        // Validate exipire time
        if (!$passwordRest->date_expiration >= now()) {
            return $this->sendError('Token déjà expiré.');
        }

        $user = User::where('email', $passwordRest->email)->first();

        if (!$user) {
            return $this->sendError('Cet utilisateur n\'existe pas.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Montrer que le token est déjà utilisé
        $passwordRest->deja_utilise = true;
        $passwordRest->save();

        return $this->sendResponse([], 'Votre mot de passe modifié avec succès.');
    }
}
