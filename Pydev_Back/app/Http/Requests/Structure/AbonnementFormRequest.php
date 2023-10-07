<?php

namespace App\Http\Requests\Client;

use App\Contracts\Client\AbonnementContract;
use Illuminate\Foundation\Http\FormRequest;

class AbonnementFormRequest extends FormRequest
{
    protected $abonnementsRepository;

    public function __construct(AbonnementContract $abonnementsRepository)
    {
        $this->abonnementsRepository = $abonnementsRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user') || $this->user()->tokencan('client');
    }

    public function rules()
    {
        $abonnement = $this->abonnementsRepository->findAbonnementByLibelle($this->libelle);
        if (isset($abonnement->id)) {
            return [
                'libelle' => ['required', 'string', 'unique:abonnements,libelle'],
                'prix' => ['required', 'unique:abonnements,prix'],
                'nombre' => ['required', 'integer', 'unique:abonnements,nombre'],
                'description' =>  'nullable|string',
            ];
        } else {
            return [
                // 'libelle' => ['required', 'string', 'unique:abonnements,libelle'],
                // 'prix' => ['required', 'unique:abonnements,prix'],
                // 'nombre' => ['required', 'integer', 'unique:abonnements,nombre'],
                // 'description' =>  'nullable|string',
            ];
        }
    }
}
