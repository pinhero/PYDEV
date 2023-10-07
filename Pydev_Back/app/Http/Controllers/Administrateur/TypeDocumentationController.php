<?php

namespace App\Http\Controllers\Administrateur;

use App\Http\Controllers\BaseController;
use App\Contracts\Administrateur\TypeDocumentationContract;
use App\Http\Requests\Administrateur\TypeDocumentationFormRequest;

class TypeDocumentationController extends BaseController
{
    protected $typeDocumentationRepository;

    public function __construct(TypeDocumentationContract $typeDocumentationRepository)
    {
        $this->middleware('scope:user')->except(['index', 'show']);

        $this->middleware(['verified', 'auth:api'])->except(['index', 'show']);

        $this->typeDocumentationRepository = $typeDocumentationRepository;
    }

    public function index()
    {
        $typeDocumentation = $this->typeDocumentationRepository->listTypeDocumentation();

        return $this->sendResponse($typeDocumentation, 'Types de documentation récupérés avec succès');
    }


    public function store(TypeDocumentationFormRequest $request)
    {

        $typeDocumentation = $this->typeDocumentationRepository->createTypeDocumentation($request->all());

        if (!$typeDocumentation) {
            return $this->sendError('Une erreur s\'est produite lors de la création du type de documentation.');
        }
        return $this->sendResponse([], 'Type de documentation créé avec succès');
    }


    public function show($slug)
    {
        $typeDocumentation = $this->typeDocumentationRepository->findTypeDocumentationBySlug(['slug' => $slug]);
        if (!$typeDocumentation) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération du type de documentation.');
        }
        return $this->sendResponse($typeDocumentation, 'Type de documentation récupéré avec succès');
    }


    public function update(TypeDocumentationFormRequest $request, $typeDocumentation)
    {
        $typeDocumentation = $this->typeDocumentationRepository->updateTypeDocumentation(['slug' => $typeDocumentation], $request->all());
        if (!$typeDocumentation) {
            return $this->sendError('Une erreur s\'est produite lors de la modification du type de documentation.');
        }
        return $this->sendResponse([], 'Type de documentation modifié avec succès');
    }

    public function destroy($id)
    {
        $typeDocumentation = $this->typeDocumentationRepository->deleteTypeDocumentation($id);
        if (!$typeDocumentation) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la catégorie.');
        }
        return $this->sendResponse([], 'Catégorie interne supprimée avec succès');
    }
}
