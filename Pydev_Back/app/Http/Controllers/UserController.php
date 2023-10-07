<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Jobs\VerifiedEmailQueueJob;

class UserController extends BaseController
{

    protected $userRepository;

    public function __construct(UserContract $userRepository)
    {
        $this->middleware('scope:user');
        $this->middleware(['verified', 'auth:api'])->except(['index']);

        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->listUsers();

        return $this->sendResponse($users, 'Utilisateurs récupérés avec succès');
    }
    public function getListeUserWithoutAdmin()
    {
        $users = $this->userRepository->getListeUserWithoutAdmin();
        return $this->sendResponse($users, 'Utilisateurs récupérés avec succès');
    }
    public function findUserByStatus(string $status)
    {
        $users = $this->userRepository->findUserByStatus($status);

        return $this->sendResponse($users, 'Utilisateurs récupérés avec succès');
    }

    public function show(int $id)
    {

        $user = $this->userRepository->findUserById($id);

        // $this->authorize('update', $user);

        if (!$user) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de l\'utilisateur.');
        }
        return $this->sendResponse($user, 'Utilisateur récupéré avec succès');
    }
    public function getUserByRole(string $role)
    {

        $user = $this->userRepository->findUserByRole($role);

        if (!$user) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de l\'utilisateur.');
        }
        return $this->sendResponse($user, 'Utilisateur récupéré avec succès');
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&]).*$/',],
        ]);
        if (!isset($request->current_password) || !Hash::check($request->current_password, Auth::user()->password)) {
            return  $this->validate->errors()->add('current_password', 'Le mot de passe fourni ne correspond pas à votre mot de passe actuel.');
        }
        
        $user = User::whereId(Auth::user()->id)->firstOrFail();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        $success = $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();
        return $success ?
            $this->sendResponse([], "Mot de passe modifié avec succès !") :
            $this->sendError("Une erreur est survenue au cours de l'opération !");
    }
    public function updateUserInformation(Request $request)
    {
        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'telephone' => 'required|string|unique:users,telephone,'.Auth::user()->id,
            'adresse' => 'required|string',
            'birthday' => 'nullable',
        ]);
        
        $user = User::whereId(Auth::user()->id)->firstOrFail();
        
        $success = $user->update($request->all());
        return $success ?
            $this->sendResponse($success, "Modification effectuée avec succès !") :
            $this->sendError("Une erreur est survenue au cours de l'opération !");
    }
    public function changerStatusUserAccount(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:CREATED,ENABLED,DISABLED',
        ]);
        $user = User::whereId($request->id)->firstOrFail();
        $user->update($request->all());
        if ($request->role === 'ROLE_CLIENT') {
            dispatch(new VerifiedEmailQueueJob($user));
            event(new Registered($user));
        }
        if ($request->status === 'ENABLED' || $request->status === 'DISABLED' ) {
            return $this->sendResponse($user, 'Compte modifié avec succès');
        }else {
            return $this->sendError('Une erreur s\'est produite lors de  l\'opération.');
        }
    }
}
