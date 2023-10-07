<?php

namespace App\Http\Requests\Client;

use App\Contracts\Client\ClientContract;
use Illuminate\Foundation\Http\FormRequest;

class ClientFormRequest extends FormRequest
{
    protected $expertRepository;

    public function __construct(ClientContract $expertRepository)
    {
        $this->expertRepository = $expertRepository;
    }


    public function authorize()
    {
        return $this->user()->tokencan('user')  || $this->user()->tokencan('client');
    }
}
