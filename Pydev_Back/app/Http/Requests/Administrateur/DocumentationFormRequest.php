<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\DocumentationContract;
use Illuminate\Foundation\Http\FormRequest;

class DocumentationFormRequest extends FormRequest
{
    protected $documentationRepository;

    public function __construct(DocumentationContract $documentationRepository)
    {
        $this->documentationRepository = $documentationRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $item = $this->documentationRepository->findDocumentationBySlug(['slug' => $this->documentation]);
        if (isset($item->id)) {
            return [
                'type_documentation_id' => ['required', 'exists:type_documentations,id'],
                'libelle' => ['required', 'string', 'unique:documentations,libelle,' . $item->id],
                'documentfr' => ['string', 'unique:documentations,documentfr,' . $item->id],
                'documenten' => ['required', 'string', 'unique:documentations,documenten,' . $item->id],
                'description' => ['nullable', 'string'],
            ];
        } else {
            return [
                'type_documentation_id' => ['required', 'exists:type_documentations,id'],
                'libelle' => ['required', 'string', 'unique:documentations,libelle'],
                'documentfr' => ['string', 'unique:documentations,documentfr'],
                'documenten' => ['required', 'string', 'unique:documentations,documenten'],
                'description' => ['nullable', 'string'],
            ];
        }
    }
}
