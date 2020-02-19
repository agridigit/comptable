<?php

namespace App\Http\Requests;

use App\CertificatNegatif;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCertificatNegatifRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('certificat_negatif_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:certificat_negatifs,id',
        ];
    }
}
