<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\CommentairePlainteContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\CommentairePlainteFormRequest;

class CommentairePlainteController extends BaseController
{
    protected $commentairePlainteRepository;

    public function __construct(CommentairePlainteContract $commentairePlainteRepository)
    {
        $this->middleware('scope:user,societe,transporteur,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->commentairePlainteRepository = $commentairePlainteRepository;
    }

    public function storeCommentairePlainte(CommentairePlainteFormRequest $request)
    {
        $request->validate([
            'description'=>'required',
            'plainte_id'=>'required',
        ]);
        $commentairePlainte = $this->commentairePlainteRepository->createCommentairePlainte($request->all());

        if (!$commentairePlainte) {
            return $this->sendError('Une erreur s\'est produite lors de la création du commentaire.');
        }
        return $this->sendResponse($commentairePlainte, 'Commentaire créée avec succès');
    }
    public function getAllCommentairePlaintesByPlainte(int $id){
        $commentairePlaintes = $this->commentairePlainteRepository->getAllCommentairePlaintesByPlainte($id);

        if (!$commentairePlaintes) {
            return $this->sendError('Une erreur s\'est produite lors de la création du commentaire.');
        }
        return $this->sendResponse($commentairePlaintes, 'Commentaires récupérés avec succès');
    }

    public function getAllCommentairePlaintes(){
        $commentairePlaintes = $this->commentairePlainteRepository->getAllCommentairePlaintes();

        if (!$commentairePlaintes) {
            return $this->sendError('Une erreur s\'est produite lors de la création du commentaire.');
        }
        return $this->sendResponse($commentairePlaintes, 'Commentaires récupérés avec succès');
    }
    public function findCommentairePlainteById(int $id){
        $commentairePlainte = $this->commentairePlainteRepository->findCommentairePlainteById($id);

        if (!$commentairePlainte) {
            return $this->sendError('Une erreur s\'est produite lors de la création du commentaire.');
        }
        return $this->sendResponse($commentairePlainte, 'Commentaire récupéré avec succès');
    }

}
