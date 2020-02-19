<?php

namespace App\Http\Requests;

use App\ListeDesMoyen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyListeDesMoyenRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('liste_des_moyen_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:liste_des_moyens,id',
        ];
    }
}
