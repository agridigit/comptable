<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTaxeProfessionnelleRequest;
use App\Http\Requests\UpdateTaxeProfessionnelleRequest;
use App\Http\Resources\Admin\TaxeProfessionnelleResource;
use App\TaxeProfessionnelle;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaxeProfessionnelleApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('taxe_professionnelle_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaxeProfessionnelleResource(TaxeProfessionnelle::all());
    }

    public function store(StoreTaxeProfessionnelleRequest $request)
    {
        $taxeProfessionnelle = TaxeProfessionnelle::create($request->all());

        if ($request->input('statut', false)) {
            $taxeProfessionnelle->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new TaxeProfessionnelleResource($taxeProfessionnelle))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TaxeProfessionnelle $taxeProfessionnelle)
    {
        abort_if(Gate::denies('taxe_professionnelle_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaxeProfessionnelleResource($taxeProfessionnelle);
    }

    public function update(UpdateTaxeProfessionnelleRequest $request, TaxeProfessionnelle $taxeProfessionnelle)
    {
        $taxeProfessionnelle->update($request->all());

        if ($request->input('statut', false)) {
            if (!$taxeProfessionnelle->statut || $request->input('statut') !== $taxeProfessionnelle->statut->file_name) {
                $taxeProfessionnelle->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($taxeProfessionnelle->statut) {
            $taxeProfessionnelle->statut->delete();
        }

        return (new TaxeProfessionnelleResource($taxeProfessionnelle))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TaxeProfessionnelle $taxeProfessionnelle)
    {
        abort_if(Gate::denies('taxe_professionnelle_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taxeProfessionnelle->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
