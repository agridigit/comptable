<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DossierAssurance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDossierAssuranceRequest;
use App\Http\Requests\UpdateDossierAssuranceRequest;
use App\Http\Resources\Admin\DossierAssuranceResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DossierAssuranceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('dossier_assurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DossierAssuranceResource(DossierAssurance::all());
    }

    public function store(StoreDossierAssuranceRequest $request)
    {
        $dossierAssurance = DossierAssurance::create($request->all());

        if ($request->input('statut', false)) {
            $dossierAssurance->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new DossierAssuranceResource($dossierAssurance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DossierAssurance $dossierAssurance)
    {
        abort_if(Gate::denies('dossier_assurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DossierAssuranceResource($dossierAssurance);
    }

    public function update(UpdateDossierAssuranceRequest $request, DossierAssurance $dossierAssurance)
    {
        $dossierAssurance->update($request->all());

        if ($request->input('statut', false)) {
            if (!$dossierAssurance->statut || $request->input('statut') !== $dossierAssurance->statut->file_name) {
                $dossierAssurance->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($dossierAssurance->statut) {
            $dossierAssurance->statut->delete();
        }

        return (new DossierAssuranceResource($dossierAssurance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DossierAssurance $dossierAssurance)
    {
        abort_if(Gate::denies('dossier_assurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dossierAssurance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
