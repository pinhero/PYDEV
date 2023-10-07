<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\DepartementContract;
use Illuminate\Foundation\Http\FormRequest;

class DepartementFormRequest extends FormRequest
{
    protected $departementRepository;

    public function __construct(DepartementContract $departementRepository)
    {
        $this->departementRepository = $departementRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $departement = $this->departementRepository->findDepartementBySlug(['slug' => $this->departement]);
        if (isset($departement->id)) {
            return [
            'pays_id' => ['required', 'exists:pays,id'],
            'name' => ['required', 'string', 'unique:departements,name,' . $departement->id],
            'code' => ['required', 'string', 'unique:departements,code,' . $departement->id],
        ];
        } else {
            return [
            'pays_id' => ['required', 'exists:pays,id'],
            'name' => ['required', 'string', 'unique:departements,name'],
            'code' => ['required', 'string', 'unique:departements,code'],
        ];
        }
        
    }
}
