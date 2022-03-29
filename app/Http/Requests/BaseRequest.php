<?php

namespace App\Http\Requests;

use Core\Application\DTOs\Response\HttpResponseDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $httpResponse = (new HttpResponseDTO(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $validator->errors()->all(),
            $this->all()
        ));

        throw new HttpResponseException(response()->json($httpResponse, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
