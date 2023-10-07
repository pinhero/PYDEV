<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\CommentairePlainteContract;
use Illuminate\Foundation\Http\FormRequest;

class CommentairePlainteFormRequest extends FormRequest
{
    protected $commentairePlainteRepository;

    public function __construct(CommentairePlainteContract $commentairePlainteRepository)
    {
        $this->commentairePlainteRepository = $commentairePlainteRepository;
    }


    public function authorize()
    {
        return $this->user()->tokencan('user')  || $this->user()->tokencan('transporteur') || $this->user()->tokencan('societe');
    }

    public function rules()
    {
            return [
                'plainte_id' => ['exists:plaintes,id'],
                'description' => ['required', 'string'],
            ];
    }
}
