<?php

namespace App\Http\Requests;

use App\GrandLivre;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreGrandLivreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('grand_livre_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'grand_livre.*' => [
                'required'],
        ];
    }
}
