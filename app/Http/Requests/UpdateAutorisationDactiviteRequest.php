<?php

namespace App\Http\Requests;

use App\AutorisationDactivite;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateAutorisationDactiviteRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('autorisation_dactivite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
