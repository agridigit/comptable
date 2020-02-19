<?php

namespace App\Http\Requests;

use App\DeclarationTva;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDeclarationTvaRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('declaration_tva_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:declaration_tvas,id',
        ];
    }
}
