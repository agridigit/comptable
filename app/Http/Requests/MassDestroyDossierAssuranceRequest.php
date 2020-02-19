<?php

namespace App\Http\Requests;

use App\DossierAssurance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDossierAssuranceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dossier_assurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dossier_assurances,id',
        ];
    }
}
