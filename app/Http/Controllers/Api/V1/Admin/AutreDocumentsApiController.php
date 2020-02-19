<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AutreDocument;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAutreDocumentRequest;
use App\Http\Requests\UpdateAutreDocumentRequest;
use App\Http\Resources\Admin\AutreDocumentResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutreDocumentsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('autre_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutreDocumentResource(AutreDocument::all());
    }

    public function store(StoreAutreDocumentRequest $request)
    {
        $autreDocument = AutreDocument::create($request->all());

        if ($request->input('statut', false)) {
            $autreDocument->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new AutreDocumentResource($autreDocument))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AutreDocument $autreDocument)
    {
        abort_if(Gate::denies('autre_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutreDocumentResource($autreDocument);
    }

    public function update(UpdateAutreDocumentRequest $request, AutreDocument $autreDocument)
    {
        $autreDocument->update($request->all());

        if ($request->input('statut', false)) {
            if (!$autreDocument->statut || $request->input('statut') !== $autreDocument->statut->file_name) {
                $autreDocument->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($autreDocument->statut) {
            $autreDocument->statut->delete();
        }

        return (new AutreDocumentResource($autreDocument))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AutreDocument $autreDocument)
    {
        abort_if(Gate::denies('autre_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autreDocument->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
