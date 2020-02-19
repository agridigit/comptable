<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRapprochementBancaireRequest;
use App\Http\Requests\UpdateRapprochementBancaireRequest;
use App\Http\Resources\Admin\RapprochementBancaireResource;
use App\RapprochementBancaire;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RapprochementBancaireApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('rapprochement_bancaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RapprochementBancaireResource(RapprochementBancaire::all());
    }

    public function store(StoreRapprochementBancaireRequest $request)
    {
        $rapprochementBancaire = RapprochementBancaire::create($request->all());

        if ($request->input('statut', false)) {
            $rapprochementBancaire->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new RapprochementBancaireResource($rapprochementBancaire))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RapprochementBancaire $rapprochementBancaire)
    {
        abort_if(Gate::denies('rapprochement_bancaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RapprochementBancaireResource($rapprochementBancaire);
    }

    public function update(UpdateRapprochementBancaireRequest $request, RapprochementBancaire $rapprochementBancaire)
    {
        $rapprochementBancaire->update($request->all());

        if ($request->input('statut', false)) {
            if (!$rapprochementBancaire->statut || $request->input('statut') !== $rapprochementBancaire->statut->file_name) {
                $rapprochementBancaire->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($rapprochementBancaire->statut) {
            $rapprochementBancaire->statut->delete();
        }

        return (new RapprochementBancaireResource($rapprochementBancaire))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RapprochementBancaire $rapprochementBancaire)
    {
        abort_if(Gate::denies('rapprochement_bancaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rapprochementBancaire->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
