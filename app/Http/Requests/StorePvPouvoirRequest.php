<?php

namespace App\Http\Requests;

use App\PvPouvoir;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePvPouvoirRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pv_pouvoir_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
