<?php

namespace App\Http\Requests;

use App\Bilan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBilanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bilan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:bilans,id',
        ];
    }
}
