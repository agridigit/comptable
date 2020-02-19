<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AutorisationDactivite;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAutorisationDactiviteRequest;
use App\Http\Requests\UpdateAutorisationDactiviteRequest;
use App\Http\Resources\Admin\AutorisationDactiviteResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutorisationDactiviteApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('autorisation_dactivite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutorisationDactiviteResource(AutorisationDactivite::all());
    }

    public function store(StoreAutorisationDactiviteRequest $request)
    {
        $autorisationDactivite = AutorisationDactivite::create($request->all());

        if ($request->input('statut', false)) {
            $autorisationDactivite->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new AutorisationDactiviteResource($autorisationDactivite))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AutorisationDactivite $autorisationDactivite)
    {
        abort_if(Gate::denies('autorisation_dactivite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutorisationDactiviteResource($autorisationDactivite);
    }

    public function update(UpdateAutorisationDactiviteRequest $request, AutorisationDactivite $autorisationDactivite)
    {
        $autorisationDactivite->update($request->all());

        if ($request->input('statut', false)) {
            if (!$autorisationDactivite->statut || $request->input('statut') !== $autorisationDactivite->statut->file_name) {
                $autorisationDactivite->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($autorisationDactivite->statut) {
            $autorisationDactivite->statut->delete();
        }

        return (new AutorisationDactiviteResource($autorisationDactivite))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AutorisationDactivite $autorisationDactivite)
    {
        abort_if(Gate::denies('autorisation_dactivite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autorisationDactivite->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
