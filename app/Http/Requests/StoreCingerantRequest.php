<?php

namespace App\Http\Requests;

use App\Cingerant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCingerantRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cingerant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'statut.*' => [
                'required'],
        ];
    }
}
