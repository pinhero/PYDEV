<?php

namespace App\Http\Requests\Expertise;

use App\Contracts\Expertise\ReponseExpertiseContract;
use Illuminate\Foundation\Http\FormRequest;

class ReponseExpertiseFormRequest extends FormRequest
{
    protected $reponseExpertiseRepository;

    public function __construct(ReponseExpertiseContract $reponseExpertiseRepository)
    {
        $this->reponseExpertiseRepository = $reponseExpertiseRepository;
    }


    public function authorize()
    {
        return $this->user()->tokencan('user')  || $this->user()->tokencan('affreteur')  || $this->user()->tokencan('transporteur') || $this->user()->tokencan('societe')|| $this->user()->tokencan('expert');
    }

    public function rules()
    {
            return [
                'expertise_id' => ['exists:expertises,id'],
                'reponse_a' => ['nullable','exists:expertises,id'],
                'expert_id' => ['exists:users,id'],
                'description' => ['required', 'string'],
            ];
    }
}
