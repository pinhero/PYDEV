<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    protected $scope;

    public function login(Request $request):JsonResponse
    {

        $this->validate($request,[
            'email' => 'bail|required',
            'password' => 'required',
            'remember_me' => 'boolean',
        ]);
        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            $user = User::findOrFail(Auth::id());
            if($user->email_verified_at == null){
                return $this->sendError('Veuillez valider votre adresse email!');
            }
            $this->scope = 'user';

            $token = $user->createToken($user->email . '-' . now(),[$this->scope]);

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }

            if ($token->token->save()) {
                $data = [
                    'token' => $token->accessToken,
                    'is_verify' => $user->email_verified_at? true : false,
                    'orcid' => $user->orcid,
                    'token_scope' => $token->token->scopes[0],
                    'expires_at' => Carbon::parse($token->token->expires_at)->format('d.m.Y H:s:i'),
                ];
                return $this->sendResponse($data, 'Utilisateur authentifié avec succès!');
            }

        } else {
            return $this->sendError('Identifiants incorrects!');
        }

    }
    public function logout(): JsonResponse
    {

        $user = Auth::user();

        $userToken = $user->token();
        $userToken->delete();
        return $this->sendResponse([], 'Logged out successful!');
    }


}
