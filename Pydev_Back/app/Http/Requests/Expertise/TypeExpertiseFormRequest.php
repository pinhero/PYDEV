<?php

namespace App\Http\Requests\Expertise;

use App\Contracts\Expertise\TypeExpertiseContract;
use Illuminate\Foundation\Http\FormRequest;

class TypeExpertiseFormRequest extends FormRequest
{
    protected $typeExpertisesRepository;

    public function __construct(TypeExpertiseContract $typeExpertisesRepository)
    {
        $this->typeExpertisesRepository = $typeExpertisesRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('transporteur') || $this->user()->tokencan('affreteur') || $this->user()->tokencan('societe') || $this->user()->tokencan('user');

    }

    public function rules()
    {
        $typeExpertise = $this->typeExpertisesRepository->findTypeExpertiseById($this->type_expertise);
        if (isset($typeExpertise->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:type_expertises,libelle,' . $typeExpertise->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'libelle' => ['required', 'string', 'unique:type_expertises,libelle'],
                'description' =>  'nullable|string',
            ];
        }
    }
}
