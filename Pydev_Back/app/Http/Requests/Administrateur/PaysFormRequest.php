<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\PaysContract;
use Illuminate\Foundation\Http\FormRequest;

class PaysFormRequest extends FormRequest
{
    protected $paysRepository;

    public function __construct(PaysContract $paysRepository)
    {
        $this->paysRepository = $paysRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        $pays = $this->paysRepository->findPaysBySlug(['slug' => $this->pay]);
        if (isset($pays->id)) {
            return [
                'country_code' => ['required', 'string', 'unique:pays,country_code,' . $pays->id],
                'country_name' => ['required', 'string', 'unique:pays,country_name,' . $pays->id],
            ];
        } else {
            return [
                'country_code' => ['required', 'string', 'unique:pays,country_code'],
                'country_name' => ['required', 'string', 'unique:pays,country_name'],
            ];
        }
        
       
    }
}
