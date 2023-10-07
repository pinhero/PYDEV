<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\MarchandiseContract;
use Illuminate\Foundation\Http\FormRequest;

class MarchandiseFormRequest extends FormRequest
{
    protected $marchandiseRepository;

    public function __construct(MarchandiseContract $marchandiseRepository)
    {
        $this->marchandiseRepository = $marchandiseRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $marchandise = $this->marchandiseRepository->findMarchandiseBySlug(['slug' => $this->marchandise]);
        if (isset($marchandise->id)) {
            return [
                'categorie_marchandise_id' => ['required', 'exists:categorie_marchandises,id'],
                'name' => ['required', 'string', 'unique:marchandises,name,' . $marchandise->id],
                'description' => ['nullable', 'string'],
                'poids' => ['required', 'numeric'],
            ];
        } else {
            return [
                'categorie_marchandise_id' => ['required', 'exists:categorie_marchandises,id'],
                'name' => ['required', 'string', 'unique:marchandises,name'],
                'description' => ['nullable', 'string'],
                'poids' => ['required', 'numeric'],
            ];
        }
    }
}
