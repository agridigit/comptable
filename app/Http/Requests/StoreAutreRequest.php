<?php

namespace App\Http\Requests;

use App\Autre;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAutreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('autre_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'autres.*' => [
                'required'],
        ];
    }
}
