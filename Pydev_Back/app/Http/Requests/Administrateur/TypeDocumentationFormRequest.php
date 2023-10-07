<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\TypeDocumentationContract;
use Illuminate\Foundation\Http\FormRequest;

class TypeDocumentationFormRequest extends FormRequest
{
    protected $typeDocumentationRepository;

    public function __construct(TypeDocumentationContract $typeDocumentationRepository)
    {
        $this->typeDocumentationRepository = $typeDocumentationRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $typeDocumentation = $this->typeDocumentationRepository->findTypeDocumentationBySlug(['slug' => $this->type_documentation]);
        if (isset($typeDocumentation->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:type_documentations,libelle,' . $typeDocumentation->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'libelle' => ['required', 'string', 'unique:type_documentations,libelle'],
                'description' =>  'nullable|string',
            ];
        }
    }
}
