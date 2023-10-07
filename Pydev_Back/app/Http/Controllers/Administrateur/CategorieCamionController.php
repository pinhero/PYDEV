<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\CategorieCamionContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\CategorieCamionFormRequest;

class CategorieCamionController extends BaseController
{
    protected $categorieCamionRepository;

    public function __construct(CategorieCamionContract $categorieCamionRepository)
    {
        $this->middleware('scope:user,affreteur')->except(['index', 'show']);
        
        $this->middleware(['verified', 'auth:api']);
        
        $this->categorieCamionRepository = $categorieCamionRepository;
    }

    public function index()
    {
        $categorieCamion = $this->categorieCamionRepository->listCategorieCamion();

        return $this->sendResponse($categorieCamion, 'Catégories de camion récupérées avec succès');
    }


    public function store(CategorieCamionFormRequest $request)
    {

        $categorieCamion = $this->categorieCamionRepository->createCategorieCamion($request->all());

        if (!$categorieCamion) {
            return $this->sendError('Une erreur s\'est produite lors de la création de la catégorie de camion.');
        }
        return $this->sendResponse([], 'Catégorie de camion créée avec succès');
    }


    public function show($slug)
    {
        $categorieCamion = $this->categorieCamionRepository->findCategorieCamionBySlug(['slug' => $slug]);
        if (!$categorieCamion) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la catégorie de camion.');
        }
        return $this->sendResponse($categorieCamion, 'Catégorie de camion récupérée avec succès');
    }


    public function update(CategorieCamionFormRequest $request, $categorieCamion)
    {
        $categorieCamion = $this->categorieCamionRepository->updateCategorieCamion(['slug' => $categorieCamion], $request->all());
        if (!$categorieCamion) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la catégorie de camion.');
        }
        return $this->sendResponse([], 'Catégorie de camion modifiée avec succès');
    }
}
