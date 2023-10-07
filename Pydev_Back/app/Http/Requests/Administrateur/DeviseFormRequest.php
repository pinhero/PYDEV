<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\DeviseContract;
use Illuminate\Foundation\Http\FormRequest;

class DeviseFormRequest extends FormRequest
{
    protected $deviseRepository;

    public function __construct(DeviseContract $deviseRepository)
    {
        $this->deviseRepository = $deviseRepository;

    }
    
    
    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $devise = $this->deviseRepository->findDeviseBySlug(['slug' => $this->devise]);

        if (isset($devise->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:devises,libelle,' . $devise->id],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                'libelle' => ['required', 'string', 'unique:devises,libelle'],
                'description' =>  'nullable|string',
            ];
        }
        
    }
}
