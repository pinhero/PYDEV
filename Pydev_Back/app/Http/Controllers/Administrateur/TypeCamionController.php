<?php

namespace App\Http\Controllers\Administrateur;

use App\Http\Controllers\BaseController;
use App\Contracts\Administrateur\TypeCamionContract;
use App\Http\Requests\Administrateur\TypeCamionFormRequest;

class TypeCamionController extends BaseController
{
    protected $typeCamionRepository;

    public function __construct(TypeCamionContract $typeCamionRepository)
    {
        $this->middleware('scope:user,affreteur,societe')->except(['index', 'show']);

        $this->middleware(['verified', 'auth:api']);

        $this->typeCamionRepository = $typeCamionRepository;
    }

    public function index()
    {
        $typeCamion = $this->typeCamionRepository->listTypeCamion();

        return $this->sendResponse($typeCamion, 'Types de camion récupérés avec succès');
    }


    public function store(TypeCamionFormRequest $request)
    {

        $typeCamion = $this->typeCamionRepository->createTypeCamion($request->all());

        if (!$typeCamion) {
            return $this->sendError('Une erreur s\'est produite lors de la création du type de camion.');
        }
        return $this->sendResponse([], 'Type de camion créé avec succès');
    }


    public function show($slug)
    {
        $typeCamion = $this->typeCamionRepository->findTypeCamionBySlug(['slug' => $slug]);
        if (!$typeCamion) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération du type de camion.');
        }
        return $this->sendResponse($typeCamion, 'Type de camion récupéré avec succès');
    }


    public function update(TypeCamionFormRequest $request, $typeCamion)
    {
        $typeCamion = $this->typeCamionRepository->updateTypeCamion(['slug' => $typeCamion], $request->all());
        if (!$typeCamion) {
            return $this->sendError('Une erreur s\'est produite lors de la modification du type de camion.');
        }
        return $this->sendResponse([], 'Type de camion modifié avec succès');
    }
}
