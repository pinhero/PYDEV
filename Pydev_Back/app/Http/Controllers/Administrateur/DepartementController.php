<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\DepartementContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\DepartementFormRequest;

class DepartementController extends BaseController
{
    protected $departementRepository;

    public function __construct(DepartementContract $departementRepository)
    {
        $this->middleware('scope:user,affreteur');


        $this->middleware(['verified', 'auth:api']);

        $this->departementRepository = $departementRepository;

    }

    public function index()
    {
        $departement = $this->departementRepository->listDepartement();

        return $this->sendResponse($departement, 'Départements récupérés avec succès');
    }


    public function store(DepartementFormRequest $request)
    {

        $departement = $this->departementRepository->createDepartement($request->all());

        if (!$departement) {
            return $this->sendError('Une erreur s\'est produite lors de la création du département.');
        }
        return $this->sendResponse([], 'Département créé avec succès');
    }


    public function show($slug)
    {
        $departement = $this->departementRepository->findDepartementBySlug(['slug' => $slug]);
        if (!$departement) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération du département.');
        }
        return $this->sendResponse($departement, 'Département récupéré avec succès');
    }
    public function findDepartementById(int $id)
    {
        $departement = $this->departementRepository->findDepartementById($id);
        if (!$departement) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération du département.');
        }
        return $this->sendResponse($departement, 'Département récupéré avec succès');
    }


    public function update(DepartementFormRequest $request, $departement)
    {
        $departement = $this->departementRepository->updateDepartement(['slug' => $departement], $request->all());
        if (!$departement) {
            return $this->sendError('Une erreur s\'est produite lors de la modification du département.');
        }
        return $this->sendResponse([], 'Département modifié avec succès');
    }
}
