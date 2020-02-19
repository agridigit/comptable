<?php

namespace App\Http\Requests;

use App\TaxeProfessionnelle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTaxeProfessionnelleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('taxe_professionnelle_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:taxe_professionnelles,id',
        ];
    }
}
