<?php

namespace App\Http\Requests\Expertise;

use App\Contracts\Expertise\CategorieExpertiseContract;
use Illuminate\Foundation\Http\FormRequest;

class CategorieExpertiseFormRequest extends FormRequest
{
    protected $categorieExpertisesRepository;

    public function __construct(CategorieExpertiseContract $categorieExpertisesRepository)
    {
        $this->categorieExpertisesRepository = $categorieExpertisesRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('transporteur') || $this->user()->tokencan('user');

    }

    public function rules()
    {
        $categorieExpertise = $this->categorieExpertisesRepository->findCategorieExpertiseBySlug(['slug' => $this->categorie_expertise]);
        if (isset($categorieExpertise->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:categorie_expertises,libelle,' . $categorieExpertise->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'libelle' => ['required', 'string', 'unique:categorie_expertises,libelle'],
                'description' =>  'nullable|string',
            ];
        }
    }
}
