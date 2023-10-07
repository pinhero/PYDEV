<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{



    protected $data = null;
    
    public function sendResponse( $data = null, string $message)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 401)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'status' => $code,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


}
