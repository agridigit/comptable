<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DeclarationTva;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDeclarationTvaRequest;
use App\Http\Requests\UpdateDeclarationTvaRequest;
use App\Http\Resources\Admin\DeclarationTvaResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeclarationTvaApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('declaration_tva_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeclarationTvaResource(DeclarationTva::all());
    }

    public function store(StoreDeclarationTvaRequest $request)
    {
        $declarationTva = DeclarationTva::create($request->all());

        if ($request->input('statut', false)) {
            $declarationTva->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new DeclarationTvaResource($declarationTva))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DeclarationTva $declarationTva)
    {
        abort_if(Gate::denies('declaration_tva_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeclarationTvaResource($declarationTva);
    }

    public function update(UpdateDeclarationTvaRequest $request, DeclarationTva $declarationTva)
    {
        $declarationTva->update($request->all());

        if ($request->input('statut', false)) {
            if (!$declarationTva->statut || $request->input('statut') !== $declarationTva->statut->file_name) {
                $declarationTva->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($declarationTva->statut) {
            $declarationTva->statut->delete();
        }

        return (new DeclarationTvaResource($declarationTva))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeclarationTva $declarationTva)
    {
        abort_if(Gate::denies('declaration_tva_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $declarationTva->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
