<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\VilleContract;
use Illuminate\Foundation\Http\FormRequest;

class VilleFormRequest extends FormRequest
{
    protected $villeRepository;

    public function __construct(VilleContract $villeRepository)
    {
        $this->villeRepository = $villeRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $ville = $this->villeRepository->findVilleBySlug(['slug' => $this->ville]);
        if (isset($ville->id)) {
            return [
                'departement_id' => ['required', 'exists:departements,id'],
                'name' => ['required', 'string', 'unique:villes,name,' . $ville->id],
            ];
        } else {
            return [
            'departement_id' => ['required', 'exists:departements,id'],
            'name' => ['required', 'string', 'unique:villes,name'],
        ];
        }
        
        
    }
}
