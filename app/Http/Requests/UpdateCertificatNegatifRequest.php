<?php

namespace App\Http\Requests;

use App\CertificatNegatif;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCertificatNegatifRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('certificat_negatif_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
