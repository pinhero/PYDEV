<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Media\Attachement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttachementController extends BaseController
{
    protected $mediaRelationship;

    public function __construct()
    {
        $this->middleware('scope:affreteur,transporteur,societe,user,expert');

        $this->middleware(['verified', 'auth:api']);

        $this->mediaRelationship = ['document', 'user','expert'];
    }

    public function storeOrUpdate(Request $request)
    {
        if ($request->id) {
            $this->validate($request,[
                'numero_piece' => 'required|unique:attachements,numero_piece,' . $request->id,
                'date_expiration' => 'required|date',
                'image' => 'required',
                'document_type' => 'required|exists:document_types,id',
            ]);
        } else {
            $this->validate($request, [
                'numero_piece' => 'required|unique:attachements,numero_piece',
                'date_expiration' => 'required|date',
                'image' => 'required',
                'document_type' => 'required|exists:document_types,id',
            ]);
        }
        if ($request->id) {
            $checkMedia = Attachement::whereId($request->id)->firstOrFail();
            if ($checkMedia->status === 'Validé') {
                return $this->sendResponse([],'Pièce déjà validée, impossible de modifier.');
            }
        }
        
        $media =  Attachement::updateOrCreate( 
           
            [
                'user_id' => Auth::user()->id,
                'document_type' => $request->document_type,
            ],
            [
                'numero_piece' => $request->numero_piece,
                'date_expiration' => Carbon::createFromDate($request->date_expiration)->format('Y-m-d'),
                'image' => $request->image,
            ]);

        return $this->sendResponse($media, 'Opération effectuée avec succès');
    }
    public function getMediaByUser()
    {
        $medias = Attachement::with($this->mediaRelationship)->whereUserId(Auth::user()->id)->get();

        return $this->sendResponse($medias, 'Pièces récupérées avec succès');
    }
    public function getMediaByUserId(int $id)
    {
        $medias = Attachement::with($this->mediaRelationship)->whereUserId($id)->get();

        return $this->sendResponse($medias, 'Pièces récupérées avec succès');
    }
    public function getMediaByID(int $id)
    {
        $media = Attachement::with($this->mediaRelationship)->whereId($id)->firstOrFail();

        return $this->sendResponse($media, 'Pièce récupérée avec succès');
    }
    public function changerStatusMedia(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:Validé,Rejeté',
            'commentaire' => 'required_if:status,Rejeté',
        ]);
        $media = Attachement::whereId($request->id)->firstOrFail();
        $media->update($request->all());
        
        if ($request->status==='Validé') {
            return $this->sendResponse( [],'Pièce validée avec succès');
        }elseif ($request->status === 'Rejeté') {
            return $this->sendResponse([],'Pièce rejetée avec succès');
        }else {
            return $this->sendError('Une erreur s\'est produite lors de  l\'opération.');
        }
    }
    public function deleteMedia(int $id)
    {

        $media = Attachement::whereId($id)->firstOrFail();
        if ($media->status === 'Validé') {
            return $this->sendError('Pièce déjà validée, impossible de supprimer.');
        } else {
            $media->delete();
            return $this->sendResponse([], 'Pièce supprimée avec succès');
        }

    }
}
