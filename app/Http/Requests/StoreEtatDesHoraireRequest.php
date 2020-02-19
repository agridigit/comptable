<?php

namespace App\Http\Requests;

use App\EtatDesHoraire;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEtatDesHoraireRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('etat_des_horaire_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'etat_des_horaires.*' => [
                'required'],
        ];
    }
}
