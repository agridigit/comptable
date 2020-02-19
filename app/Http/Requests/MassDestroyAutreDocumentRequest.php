<?php

namespace App\Http\Requests;

use App\AutreDocument;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAutreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('autre_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:autre_documents,id',
        ];
    }
}
