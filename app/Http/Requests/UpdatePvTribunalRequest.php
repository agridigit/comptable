<?php

namespace App\Http\Requests;

use App\PvTribunal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePvTribunalRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pv_tribunal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
