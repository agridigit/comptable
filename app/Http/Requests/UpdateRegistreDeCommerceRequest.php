<?php

namespace App\Http\Requests;

use App\RegistreDeCommerce;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRegistreDeCommerceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('registre_de_commerce_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
