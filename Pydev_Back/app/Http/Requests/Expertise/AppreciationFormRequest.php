<?php

namespace App\Http\Requests\Expertise;

use App\Contracts\Expertise\AppreciationContract;
use Illuminate\Foundation\Http\FormRequest;

class AppreciationFormRequest extends FormRequest
{
    protected $appreciationRepository;

    public function __construct(AppreciationContract $appreciationRepository)
    {
        $this->appreciationRepository = $appreciationRepository;
    }


    public function authorize()
    {
        return $this->user()->tokencan('user')  || $this->user()->tokencan('affreteur')  || $this->user()->tokencan('transporteur') || $this->user()->tokencan('societe')|| $this->user()->tokencan('expert');
    }

    public function rules()
    {
            return [
                'expertise_id' => ['exists:expertises,id'],
                'note' => ['required','integer'],
                'expert_id' => ['exists:users,id'],
            ];
    }
}
