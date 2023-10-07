<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\DocumentTypeContract;
use Illuminate\Foundation\Http\FormRequest;

class DocumentTypeFormRequest extends FormRequest
{
    protected $documentTypeRepository;

    public function __construct(DocumentTypeContract $documentTypeRepository)
    {
        $this->documentTypeRepository = $documentTypeRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $documentType = $this->documentTypeRepository->findDocumentTypeBySlug(['slug' => $this->document]);
        if (isset($documentType->id)) {
            return [
                'name' => ['required', 'string', 'unique:document_types,name,' . $documentType->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'name' => ['required', 'string', 'unique:document_types,name'],
                'description' =>  'nullable|string',
            ];
        }
        
        
    }
}
