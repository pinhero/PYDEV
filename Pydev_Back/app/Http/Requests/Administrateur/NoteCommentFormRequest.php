<?php

namespace App\Http\Requests\Administrateur;

use App\Contracts\Administrateur\NoteCommentContract;
use Illuminate\Foundation\Http\FormRequest;

class NoteCommentFormRequest extends FormRequest
{
    protected $noteCommentRepository;

    public function __construct(NoteCommentContract $noteCommentRepository)
    {
        $this->noteCommentRepository = $noteCommentRepository;
    }


    public function authorize()
    {
        // Unique l'user
        return $this->user()->tokencan('user');

    }

    public function rules()
    {
        return [
            'type' => ['required', 'string'],
            'comment' =>  'required|string',
            'value' =>  'required|numeric|min:1',
        ];
    }
}
