<?php

namespace App\Http\Requests;

use App\Statut;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateStatutRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('statut_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
