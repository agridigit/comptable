<?php

namespace App\Http\Requests;

use App\IrSurSalaire;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyIrSurSalaireRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ir_sur_salaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ir_sur_salaires,id',
        ];
    }
}
