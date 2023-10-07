<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\PaysContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\PaysFormRequest;

class PaysController extends BaseController
{

    protected $paysRepository;

    public function __construct(PaysContract $paysRepository)
    {
        $this->middleware('scope:user,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->paysRepository = $paysRepository;
    }

    public function index()
    {
        $pays = $this->paysRepository->listPays();

        return $this->sendResponse($pays, 'Pays récupérés avec succès');
    }


    public function store(PaysFormRequest $request)
    {

        $pays = $this->paysRepository->createPays($request->all());

        if (!$pays) {
            return $this->sendError('Une erreur s\'est produite lors de la création du pays.');
        }
        return $this->sendResponse([], 'Pays créé avec succès');
    }


    public function show($slug)
    {
        $pays = $this->paysRepository->findPaysBySlug(['slug' => $slug]);
        if (!$pays) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération du pays.');
        }
        return $this->sendResponse($pays, 'Pays récupéré avec succès');
    }


    public function update(PaysFormRequest $request, $pays)
    {
        $pays = $this->paysRepository->updatePays(['slug' => $pays], $request->all());
        if (!$pays) {
            return $this->sendError('Une erreur s\'est produite lors de la modification du pays.');
        }
        return $this->sendResponse([], 'Pays modifié avec succès');
    }
}
