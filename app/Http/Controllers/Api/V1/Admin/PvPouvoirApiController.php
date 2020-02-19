<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePvPouvoirRequest;
use App\Http\Requests\UpdatePvPouvoirRequest;
use App\Http\Resources\Admin\PvPouvoirResource;
use App\PvPouvoir;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PvPouvoirApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('pv_pouvoir_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PvPouvoirResource(PvPouvoir::all());
    }

    public function store(StorePvPouvoirRequest $request)
    {
        $pvPouvoir = PvPouvoir::create($request->all());

        if ($request->input('statut', false)) {
            $pvPouvoir->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new PvPouvoirResource($pvPouvoir))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PvPouvoir $pvPouvoir)
    {
        abort_if(Gate::denies('pv_pouvoir_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PvPouvoirResource($pvPouvoir);
    }

    public function update(UpdatePvPouvoirRequest $request, PvPouvoir $pvPouvoir)
    {
        $pvPouvoir->update($request->all());

        if ($request->input('statut', false)) {
            if (!$pvPouvoir->statut || $request->input('statut') !== $pvPouvoir->statut->file_name) {
                $pvPouvoir->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($pvPouvoir->statut) {
            $pvPouvoir->statut->delete();
        }

        return (new PvPouvoirResource($pvPouvoir))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PvPouvoir $pvPouvoir)
    {
        abort_if(Gate::denies('pv_pouvoir_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pvPouvoir->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
