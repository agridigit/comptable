<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreIdentifiantFiscalRequest;
use App\Http\Requests\UpdateIdentifiantFiscalRequest;
use App\Http\Resources\Admin\IdentifiantFiscalResource;
use App\IdentifiantFiscal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifiantFiscalApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('identifiant_fiscal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IdentifiantFiscalResource(IdentifiantFiscal::all());
    }

    public function store(StoreIdentifiantFiscalRequest $request)
    {
        $identifiantFiscal = IdentifiantFiscal::create($request->all());

        if ($request->input('statut', false)) {
            $identifiantFiscal->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new IdentifiantFiscalResource($identifiantFiscal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(IdentifiantFiscal $identifiantFiscal)
    {
        abort_if(Gate::denies('identifiant_fiscal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IdentifiantFiscalResource($identifiantFiscal);
    }

    public function update(UpdateIdentifiantFiscalRequest $request, IdentifiantFiscal $identifiantFiscal)
    {
        $identifiantFiscal->update($request->all());

        if ($request->input('statut', false)) {
            if (!$identifiantFiscal->statut || $request->input('statut') !== $identifiantFiscal->statut->file_name) {
                $identifiantFiscal->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($identifiantFiscal->statut) {
            $identifiantFiscal->statut->delete();
        }

        return (new IdentifiantFiscalResource($identifiantFiscal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(IdentifiantFiscal $identifiantFiscal)
    {
        abort_if(Gate::denies('identifiant_fiscal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $identifiantFiscal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
