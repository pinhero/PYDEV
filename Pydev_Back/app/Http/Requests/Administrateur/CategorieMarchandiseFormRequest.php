<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\CategorieMarchandiseContract;
use Illuminate\Foundation\Http\FormRequest;

class CategorieMarchandiseFormRequest extends FormRequest
{
    protected $categorieMarchandiseRepository;

    public function __construct(CategorieMarchandiseContract $categorieMarchandiseRepository)
    {
        $this->categorieMarchandiseRepository = $categorieMarchandiseRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $categorieMarchandise = $this->categorieMarchandiseRepository->findCategorieMarchandiseBySlug(['slug' => $this->categorie_marchandise]);

        if (isset($categorieMarchandise->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:categorie_marchandises,libelle,' . $categorieMarchandise->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'libelle' => ['required', 'string', 'unique:categorie_marchandises,libelle'],
                'description' =>  'nullable|string',
            ];
        }
    }
}
