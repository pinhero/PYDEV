<?php

namespace App\Http\Controllers\Administrateur;

use App\Http\Controllers\BaseController;
use App\Contracts\Administrateur\MarchandiseContract;
use App\Http\Requests\Administrateur\MarchandiseFormRequest;

class MarchandiseController extends BaseController
{
    protected $marchandiseRepository;

    public function __construct(MarchandiseContract $marchandiseRepository)
    {
        $this->middleware('scope:user,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->marchandiseRepository = $marchandiseRepository;
    }

    public function index()
    {
        $marchandises = $this->marchandiseRepository->listMarchandise();

        return $this->sendResponse($marchandises, 'Marchandises récupérées avec succès');
    }


    public function store(MarchandiseFormRequest $request)
    {

        $marchandise = $this->marchandiseRepository->createMarchandise($request->all());

        if (!$marchandise) {
            return $this->sendError('Une erreur s\'est produite lors de la création de la marchandise.');
        }
        return $this->sendResponse([], 'Marchandise créée avec succès');
    }


    public function show($slug)
    {
        $marchandise = $this->marchandiseRepository->findMarchandiseBySlug(['slug' => $slug]);
        if (!$marchandise) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la marchandise.');
        }
        return $this->sendResponse($marchandise, 'Marchandise récupérée avec succès');
    }


    public function update(MarchandiseFormRequest $request, $marchandise)
    {
        $marchandise = $this->marchandiseRepository->updateMarchandise(['slug' => $marchandise], $request->all());
        if (!$marchandise) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la marchandise.');
        }
        return $this->sendResponse([], 'Marchandise modifiée avec succès');
    }


    public function destroy($id)
    {
        //
    }
}
