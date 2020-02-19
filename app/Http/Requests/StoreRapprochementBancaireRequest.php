<?php

namespace App\Http\Requests;

use App\RapprochementBancaire;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRapprochementBancaireRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('rapprochement_bancaire_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'statut.*' => [
                'required'],
            'du'       => [
                'date_format:' . config('panel.date_format'),
                'nullable'],
            'au'       => [
                'date_format:' . config('panel.date_format'),
                'nullable'],
        ];
    }
}
