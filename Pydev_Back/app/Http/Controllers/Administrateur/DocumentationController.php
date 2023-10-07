<?php

namespace App\Http\Controllers\Administrateur;

use App\Http\Controllers\BaseController;
use App\Models\Administrateur\Documentation;
use App\Contracts\Administrateur\DocumentationContract;
use App\Http\Requests\Administrateur\DocumentationFormRequest;
use Illuminate\Http\Request;


class DocumentationController extends BaseController
{
    protected $documentationRepository;

    public function __construct(DocumentationContract $documentationRepository)
    {
        $this->middleware('scope:user')->except(['index', 'show', 'getDocumentByType']);

        $this->middleware(['verified', 'auth:api'])->except(['index', 'show', 'getDocumentByType']);

        $this->documentationRepository = $documentationRepository;
    }

    public function index()
    {
        $documentations = $this->documentationRepository->listDocumentation();
        // foreach ($documentations as $documentation) {
        //     $documentation['type'] =$documentation->type_documentations->libelle;
        // }
        return $documentations ?
            $this->sendResponse($documentations, 'Documentation récupérée avec succès') :
            $this->sendError("Une erreur est survenue au cours de l'opération !");
    }


    public function store(DocumentationFormRequest $request)
    {

        $documentation = $this->documentationRepository->createDocumentation($request->all());
        if (!$documentation) {
            return $this->sendError('Une erreur s\'est produite lors de la création de la documentation.');
        }
        return $this->sendResponse([], 'Documentation créée avec succès');
    }

    public function getDocumentByType(Request $request)
    {
        $query = Documentation::whereTypeDocumentationId($request->type);

        if (!is_null($request->date_debut) && !is_null($request->date_fin)) {
            $query->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
        }

        if (!is_null($request->search)) {
            $query->where('description', 'LIKE', '%' . $request->search . '%');
            $query->orWhere('libelle', 'LIKE', '%' . $request->search . '%');
        }

        $documents = $query->latest()->paginate($request->pagesize);

        return response()->json([
            'data' => $documents,
            'statut' => 200,
            'success' => true,

        ]);

    }

    public function show($slug)
    {
        $documentation = $this->documentationRepository->findDocumentationBySlug(['slug' => $slug]);
        if (!$documentation) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la documentation.');
        }
        return $this->sendResponse($documentation, 'Documentation récupérée avec succès');
    }


    public function update(DocumentationFormRequest $request, $documentation)
    {
        $item = $this->documentationRepository->updateDocumentation(['slug' => $documentation], $request->all());
        if (!$item) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la documentation.');
        }
        return $this->sendResponse([], 'Documentation modifiée avec succès');
    }

    public function destroy($id)
    {
        $documentation = $this->documentationRepository->deleteDocumentation($id);
        if (!$documentation) {
            return $this->sendError('Une erreur s\'est produite lors de la suppression de la documentation.');
        }
        return $this->sendResponse([], 'Documentation supprimée avec succès');
    }
}
