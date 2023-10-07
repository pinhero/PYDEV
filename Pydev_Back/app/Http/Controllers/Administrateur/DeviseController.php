<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\DeviseContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\DeviseFormRequest;

class DeviseController extends BaseController
{
    protected $deviseRepository;

    public function __construct(DeviseContract $deviseRepository)
    {
        $this->middleware('scope:user')->except(['index']);

        $this->middleware(['verified', 'auth:api']);

        $this->deviseRepository = $deviseRepository;
    }
    
    public function index()
    {
        $devises = $this->deviseRepository->listDevises();
        
        return $this->sendResponse($devises,'Devises récupérées avec succès');
    }

    
    public function store(DeviseFormRequest $request)
    {
        
        $devise = $this->deviseRepository->createDevise($request->all());

        if (!$devise) {
            return $this->sendError('Une erreur s\'est produite lors de la création de la devise.');
        }
        return $this->sendResponse([], 'Devise créée avec succès');
    }

   
    public function show($slug)
    {
        $devise = $this->deviseRepository->findDeviseBySlug(['slug'=> $slug]);
        if (!$devise) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la devise.');
        }
        return $this->sendResponse($devise, 'Devise récupérée avec succès');
    }

   
    public function update(DeviseFormRequest $request,$devise)
    {
        $devise = $this->deviseRepository->updateDevise(['slug' => $devise],$request->all());
        if (!$devise) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la devise.');
        }
        return $this->sendResponse([],'Devise modifiée avec succès');

    }

    
    public function destroy($id)
    {
        //
    }
}
