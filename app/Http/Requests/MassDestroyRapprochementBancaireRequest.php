<?php

namespace App\Http\Requests;

use App\RapprochementBancaire;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRapprochementBancaireRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('rapprochement_bancaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:rapprochement_bancaires,id',
        ];
    }
}
