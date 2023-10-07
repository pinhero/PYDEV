<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\NoteCommentContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\NoteCommentFormRequest;

class NoteCommentController extends BaseController
{
    protected $noteCommentRepository;

    public function __construct(NoteCommentContract $noteCommentRepository)
    {
        $this->middleware('scope:user,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->noteCommentRepository = $noteCommentRepository;
    }

    public function index()
    {
        $noteComment = $this->noteCommentRepository->listNoteComment();

        return $this->sendResponse($noteComment, 'Informations récupérées avec succès');
    }


    public function store(NoteCommentFormRequest $request)
    {

        $noteComment = $this->noteCommentRepository->createNoteComment($request->all());

        if (!$noteComment) {
            return $this->sendError('Une erreur s\'est produite lors de la création des informations.');
        }
        return $this->sendResponse([], 'Note créée avec succès');
    }


    public function show($id)
    {
        $noteComment = $this->noteCommentRepository->findNoteCommentById($id);
        if (!$noteComment) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération des informations.');
        }
        return $this->sendResponse($noteComment, 'Note récupérée avec succès');
    }


    public function update(NoteCommentFormRequest $request, $noteComment)
    {
        $noteComment = $this->noteCommentRepository->updateNoteComment($request->all());
        if (!$noteComment) {
            return $this->sendError('Une erreur s\'est produite lors de la modification des informations.');
        }
        return $this->sendResponse([], 'Note modifiée avec succès');
    }
}
