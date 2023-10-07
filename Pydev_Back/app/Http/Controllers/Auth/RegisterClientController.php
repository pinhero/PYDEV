<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\WelcomeEmailQueueJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\UserFormRequest;

class RegisterClientController extends BaseController
{
    public function __invoke(UserFormRequest $request)
    {
        $password = Hash::make($request->password); //Hash the password, we can also use bcrypt()
        //Create user based on the role
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'status' => $request->status,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $password,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        dispatch(new WelcomeEmailQueueJob($user));
        // event(new Registered($user));

        $success =  $user;
        $success['token'] =  $user->createToken($user->email . '-' . now(), [$request->scopes])->accessToken;
        
        return $this->sendResponse($success, 'Utilisateur enregistré avec succès.');
    }
}
