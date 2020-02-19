<?php

namespace App\Http\Requests;

use App\DossierAssurance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateDossierAssuranceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dossier_assurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
