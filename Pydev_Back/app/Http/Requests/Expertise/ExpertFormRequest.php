<?php

namespace App\Http\Requests\Expertise;

use App\Contracts\Expertise\ExpertContract;
use Illuminate\Foundation\Http\FormRequest;

class ExpertFormRequest extends FormRequest
{
    protected $expertRepository;

    public function __construct(ExpertContract $expertRepository)
    {
        $this->expertRepository = $expertRepository;
    }


    public function authorize()
    {
        return $this->user()->tokencan('user')  || $this->user()->tokencan('transporteur') || $this->user()->tokencan('societe')|| $this->user()->tokencan('expert');
    }

}
