<?php


namespace App\Traits;

use Illuminate\Support\Facades\Validator;


trait MyValidator
{
    /**
     * @param $champs
     * @return array
     */
    function validation($data, $rules, $errorMessage)
    {
        $validator = Validator::make($data, $rules);
        $errors = $validator->errors();

        return $errors;
        // $validator->fails();
    }

}
