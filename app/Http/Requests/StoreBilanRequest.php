<?php

namespace App\Http\Requests;

use App\Bilan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBilanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bilan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
