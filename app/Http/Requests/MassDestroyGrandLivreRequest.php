<?php

namespace App\Http\Requests;

use App\GrandLivre;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGrandLivreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('grand_livre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:grand_livres,id',
        ];
    }
}
