<?php

namespace App\Http\Controllers\Administrateur;

use App\Contracts\Administrateur\CategorieMarchandiseContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrateur\CategorieMarchandiseFormRequest;

class CategorieMarchandiseController extends BaseController
{
    protected $categorieMarchandiseRepository;

    public function __construct(CategorieMarchandiseContract $categorieMarchandiseRepository)
    {
        $this->middleware('scope:user,affreteur');

        $this->middleware(['verified', 'auth:api']);

        $this->categorieMarchandiseRepository = $categorieMarchandiseRepository;
    }

    public function index()
    {
        $categorieMarchandises = $this->categorieMarchandiseRepository->listCategorieMarchandise();

        return $this->sendResponse($categorieMarchandises, 'Catégories de marchandise récupérées avec succès');
    }


    public function store(CategorieMarchandiseFormRequest $request)
    {

        $categorieMarchandise = $this->categorieMarchandiseRepository->createCategorieMarchandise($request->all());

        if (!$categorieMarchandise) {
            return $this->sendError('Une erreur s\'est produite lors de la création de la catégorie de marchandise.');
        }
        return $this->sendResponse([], 'Catégorie de marchandise créée avec succès');
    }


    public function show($slug)
    {
        $categorieMarchandise = $this->categorieMarchandiseRepository->findCategorieMarchandiseBySlug(['slug' => $slug]);
        if (!$categorieMarchandise) {
            return $this->sendError('Une erreur s\'est produite lors de la récupération de la catégorie de marchandise.');
        }
        return $this->sendResponse($categorieMarchandise, 'Catégorie de marchandise récupérée avec succès');
    }


    public function update(CategorieMarchandiseFormRequest $request, $categorieMarchandise)
    {
        $categorieMarchandise = $this->categorieMarchandiseRepository->updateCategorieMarchandise(['slug' => $categorieMarchandise], $request->all());
        if (!$categorieMarchandise) {
            return $this->sendError('Une erreur s\'est produite lors de la modification de la catégorie de marchandise.');
        }
        return $this->sendResponse([], 'Catégorie de marchandise modifiée avec succès');
    }


    public function destroy($id)
    {
        //
    }

}
