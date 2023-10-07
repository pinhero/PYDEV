<?php

namespace App\Http\Controllers\Administrateur;


use App\Contracts\Administrateur\UniteMesureContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\UniteMesureFormRequest;

class UniteMesureController extends BaseController
{
    protected $uniteMesureRepository;

    public function __construct(UniteMesureContract $uniteMesureRepository)
    {
        $this->middleware('scope:user,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->uniteMesureRepository = $uniteMesureRepository;
    }

    public function index()
    {
        $uniteMesure = $this->uniteMesureRepository->listUniteMesure();

        return $this->sendResponse($uniteMesure, 'Unités de mesure récupérées avec succès');
    }


    public function store(UniteMesureFormRequest $request)
    {

        $uniteMesure = $this->uniteMesureRepository->createUniteMesure($request->all());

        if (!$uniteMesure) {
            return $this->sendError('Une erreur s\'est produite lors de la création de l\'unité de mesure.');
        }
        return $this->sendResponse([], 'Unité de mesure créée avec succès');
    }


    public function show($slug)
    {
        $uniteMesure = $this->uniteMesureRepository->findUniteMesureBySlug(['slug' => $slug]);
        if (!$uniteMesure) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de l\'unité de mesure.');
        }
        return $this->sendResponse($uniteMesure, 'Unité de mesure récupérée avec succès');
    }


    public function update(UniteMesureFormRequest $request, $uniteMesure)
    {
        $uniteMesure = $this->uniteMesureRepository->updateUniteMesure(['slug' => $uniteMesure], $request->all());
        if (!$uniteMesure) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de l\'unité de mesure.');
        }
        return $this->sendResponse([], 'Unité de mesure modifiée avec succès');
    }
}
