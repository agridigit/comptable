<?php

namespace App\Http\Requests;

use App\Balance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateBalanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('balance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
