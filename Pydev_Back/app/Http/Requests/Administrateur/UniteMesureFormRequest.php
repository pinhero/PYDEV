<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\UniteMesureContract;
use Illuminate\Foundation\Http\FormRequest;

class UniteMesureFormRequest extends FormRequest
{
    protected $uniteMesureRepository;

    public function __construct(UniteMesureContract $uniteMesureRepository)
    {
        $this->uniteMesureRepository = $uniteMesureRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $uniteMesure = $this->uniteMesureRepository->findUniteMesureBySlug(['slug' => $this->unite_mesure]);

        if (isset($uniteMesure->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:unite_mesures,libelle,' . $uniteMesure->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'libelle' => ['required', 'string', 'unique:unite_mesures,libelle'],
                'description' =>  'nullable|string',
            ];
        }
    }
}
