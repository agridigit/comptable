<?php

namespace App\Http\Requests;

use App\AutreDocument;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateAutreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('autre_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
