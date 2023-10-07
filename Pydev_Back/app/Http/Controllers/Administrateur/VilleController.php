<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\VilleContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\VilleFormRequest;

class VilleController extends BaseController
{
    protected $villeRepository;

    public function __construct(VilleContract $villeRepository)
    {
        $this->middleware('scope:user,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->villeRepository = $villeRepository;
    }

    public function index()
    {
        $ville = $this->villeRepository->listVille();

        return $this->sendResponse($ville, 'Ville récupérées avec succès');
    }


    public function store(VilleFormRequest $request)
    {

        $ville = $this->villeRepository->createVille($request->all());

        if (!$ville) {
            return $this->sendError('Une erreur s\'est produite lors de la création de la ville.');
        }
        return $this->sendResponse([], 'Ville créée avec succès');
    }


    public function show($slug)
    {
        $ville = $this->villeRepository->findVilleBySlug(['slug' => $slug]);
        if (!$ville) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la ville.');
        }
        return $this->sendResponse($ville, 'Ville récupérée avec succès');
    }
    public function findVilleById($id)
    {
        $ville = $this->villeRepository->findVilleById($id);
        if (!$ville) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la ville.');
        }
        return $this->sendResponse($ville, 'Ville récupérée avec succès');
    }


    public function update(VilleFormRequest $request, $ville)
    {
        $ville = $this->villeRepository->updateVille(['slug' => $ville], $request->all());
        if (!$ville) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la ville.');
        }
        return $this->sendResponse([], 'Ville modifiée avec succès');
    }
}
