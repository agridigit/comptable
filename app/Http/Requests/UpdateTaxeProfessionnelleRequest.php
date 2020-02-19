<?php

namespace App\Http\Requests;

use App\TaxeProfessionnelle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaxeProfessionnelleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('taxe_professionnelle_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
