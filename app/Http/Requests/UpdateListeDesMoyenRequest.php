<?php

namespace App\Http\Requests;

use App\ListeDesMoyen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateListeDesMoyenRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('liste_des_moyen_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
