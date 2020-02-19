<?php

namespace App\Http\Requests;

use App\IdentifiantFiscal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreIdentifiantFiscalRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('identifiant_fiscal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
