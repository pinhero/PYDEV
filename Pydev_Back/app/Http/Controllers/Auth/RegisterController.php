<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\UserFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController
{

    public function __invoke(UserFormRequest $request)
    {
        $password = Hash::make($request->password); //Hash the password, we can also use bcrypt()
        //Create user based on the role
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'orcid' => $request->orcid,
                'email' => $request->email,
                'password' => $password,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        event(new Registered($user));

        $success =  $user;
        $success['token'] =  $user->createToken($user->email . '-' . now(), ['user'])->accessToken;

        return $this->sendResponse($success, 'Utilisateur enregistré avec succès.');
    }
}
