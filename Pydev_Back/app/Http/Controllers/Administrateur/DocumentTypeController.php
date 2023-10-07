<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\DocumentTypeContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\DocumentTypeFormRequest;

class DocumentTypeController extends BaseController
{
    protected $documentTypeRepository;

    public function __construct(DocumentTypeContract $documentTypeRepository)
    {
        $this->middleware('scope:user,affreteur')->except(['index', 'show']);

        $this->middleware(['verified', 'auth:api'])->except(['index', 'show']);

        $this->documentTypeRepository = $documentTypeRepository;
    }

    public function index()
    {
        $documentType = $this->documentTypeRepository->listDocumentType();

        return $this->sendResponse($documentType, 'Types de document récupérés avec succès');
    }


    public function store(DocumentTypeFormRequest $request)
    {

        $documentType = $this->documentTypeRepository->createDocumentType($request->all());

        if (!$documentType) {
            return $this->sendError('Une erreur s\'est produite lors de la création du type de document.');
        }
        return $this->sendResponse([], 'Type de document créé avec succès');
    }


    public function show($slug)
    {
        $documentType = $this->documentTypeRepository->findDocumentTypeBySlug(['slug' => $slug]);
        if (!$documentType) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération du type de document.');
        }
        return $this->sendResponse($documentType, 'Type de document récupéré avec succès');
    }


    public function update(DocumentTypeFormRequest $request, $documentType)
    {
        $documentType = $this->documentTypeRepository->updateDocumentType(['slug' => $documentType], $request->all());
        if (!$documentType) {
            return $this->sendError('Une erreur s\'est produite lors de la modification du type de document.');
        }
        return $this->sendResponse([], 'Type de document modifié avec succès');
    }
}
