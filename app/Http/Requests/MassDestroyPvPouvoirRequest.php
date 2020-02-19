<?php

namespace App\Http\Requests;

use App\PvPouvoir;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPvPouvoirRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pv_pouvoir_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:pv_pouvoirs,id',
        ];
    }
}
