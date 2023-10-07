<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\CategorieCamionContract;
use Illuminate\Foundation\Http\FormRequest;

class CategorieCamionFormRequest extends FormRequest
{
    protected $categorieCamionRepository;

    public function __construct(CategorieCamionContract $categorieCamionRepository)
    {
        $this->categorieCamionRepository = $categorieCamionRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $categorieCamion = $this->categorieCamionRepository->findCategorieCamionBySlug(['slug' => $this->categorie_camion]);
        if (isset($categorieCamion->id)) {
            return [
                'name' => ['required', 'string', 'unique:categorie_camions,name,' . $categorieCamion->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'name' => ['required', 'string', 'unique:categorie_camions,name'],
                'description' =>  'nullable|string',
            ];
        }
    }
}
