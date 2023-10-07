<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\TypeCamionContract;
use Illuminate\Foundation\Http\FormRequest;

class TypeCamionFormRequest extends FormRequest
{
    protected $typeCamionRepository;

    public function __construct(TypeCamionContract $typeCamionRepository)
    {
        $this->typeCamionRepository = $typeCamionRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $typeCamion = $this->typeCamionRepository->findTypeCamionBySlug(['slug' => $this->type_camion]);
        if (isset($typeCamion->id)) {
            return [
                'categorie_camion_id' => ['required', 'exists:categorie_camions,id'],
                'libelle' => ['required', 'string', 'unique:type_camions,libelle,' . $typeCamion->id],
                'description' => ['nullable', 'string'],
            ];
        } else {
            return [
                'categorie_camion_id' => ['required', 'exists:categorie_camions,id'],
                'libelle' => ['required', 'string', 'unique:type_camions,libelle'],
                'description' => ['nullable', 'string'],
            ];
        }
    }
}
