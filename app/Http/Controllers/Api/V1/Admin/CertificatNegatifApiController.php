<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CertificatNegatif;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCertificatNegatifRequest;
use App\Http\Requests\UpdateCertificatNegatifRequest;
use App\Http\Resources\Admin\CertificatNegatifResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CertificatNegatifApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('certificat_negatif_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CertificatNegatifResource(CertificatNegatif::all());
    }

    public function store(StoreCertificatNegatifRequest $request)
    {
        $certificatNegatif = CertificatNegatif::create($request->all());

        if ($request->input('statut', false)) {
            $certificatNegatif->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new CertificatNegatifResource($certificatNegatif))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CertificatNegatif $certificatNegatif)
    {
        abort_if(Gate::denies('certificat_negatif_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CertificatNegatifResource($certificatNegatif);
    }

    public function update(UpdateCertificatNegatifRequest $request, CertificatNegatif $certificatNegatif)
    {
        $certificatNegatif->update($request->all());

        if ($request->input('statut', false)) {
            if (!$certificatNegatif->statut || $request->input('statut') !== $certificatNegatif->statut->file_name) {
                $certificatNegatif->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($certificatNegatif->statut) {
            $certificatNegatif->statut->delete();
        }

        return (new CertificatNegatifResource($certificatNegatif))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CertificatNegatif $certificatNegatif)
    {
        abort_if(Gate::denies('certificat_negatif_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $certificatNegatif->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
