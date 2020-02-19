<?php

namespace App\Http\Requests;

use App\GrandLivre;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateGrandLivreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('grand_livre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
