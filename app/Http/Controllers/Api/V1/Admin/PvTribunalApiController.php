<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePvTribunalRequest;
use App\Http\Requests\UpdatePvTribunalRequest;
use App\Http\Resources\Admin\PvTribunalResource;
use App\PvTribunal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PvTribunalApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('pv_tribunal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PvTribunalResource(PvTribunal::all());
    }

    public function store(StorePvTribunalRequest $request)
    {
        $pvTribunal = PvTribunal::create($request->all());

        if ($request->input('statut', false)) {
            $pvTribunal->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new PvTribunalResource($pvTribunal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PvTribunal $pvTribunal)
    {
        abort_if(Gate::denies('pv_tribunal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PvTribunalResource($pvTribunal);
    }

    public function update(UpdatePvTribunalRequest $request, PvTribunal $pvTribunal)
    {
        $pvTribunal->update($request->all());

        if ($request->input('statut', false)) {
            if (!$pvTribunal->statut || $request->input('statut') !== $pvTribunal->statut->file_name) {
                $pvTribunal->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($pvTribunal->statut) {
            $pvTribunal->statut->delete();
        }

        return (new PvTribunalResource($pvTribunal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PvTribunal $pvTribunal)
    {
        abort_if(Gate::denies('pv_tribunal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pvTribunal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
