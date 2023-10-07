<?php

namespace App\Http\Requests\Expertise;

use App\Contracts\Expertise\ExpertiseContract;
use Illuminate\Foundation\Http\FormRequest;

class ExpertiseFormRequest extends FormRequest
{
    protected $expertiseRepository;

    public function __construct(ExpertiseContract $expertiseRepository)
    {
        $this->expertiseRepository = $expertiseRepository;
    }
    public function authorize()
    {
        
        return $this->user()->tokencan('transporteur') || $this->user()->tokencan('affreteur') || $this->user()->tokencan('societe') || $this->user()->tokencan('user');
    }

    public function rules()
    {
        $expertises = $this->expertiseRepository->findExpertiseBySlug(['slug' => $this->expertise]);
        if (isset($expertises->id)) {
            return [
                'categorie_expertise_id' => ['required', 'exists:categorie_expertises,id'],
                'type_expertise_id' => ['required', 'exists:type_expertises,id'],
                'question' => ['required', 'string'],
                'statut' =>  'required|boolean',
                'user_id' =>  ['required', 'exists:users,id'],
            ];
        } else {
            return [
                'categorie_expertise_id' => ['required', 'exists:categorie_expertises,id'],
                'type_expertise_id' => ['required', 'exists:type_expertises,id'],
                'question' => ['required', 'string'],
                'statut' =>  'required|boolean',
                'user_id' =>  ['required', 'exists:users,id'],
            ];
        }
    }
}
