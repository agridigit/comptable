<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreStatutRequest;
use App\Http\Requests\UpdateStatutRequest;
use App\Http\Resources\Admin\StatutResource;
use App\Statut;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatutApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('statut_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StatutResource(Statut::all());
    }

    public function store(StoreStatutRequest $request)
    {
        $statut = Statut::create($request->all());

        if ($request->input('statut', false)) {
            $statut->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new StatutResource($statut))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Statut $statut)
    {
        abort_if(Gate::denies('statut_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StatutResource($statut);
    }

    public function update(UpdateStatutRequest $request, Statut $statut)
    {
        $statut->update($request->all());

        if ($request->input('statut', false)) {
            if (!$statut->statut || $request->input('statut') !== $statut->statut->file_name) {
                $statut->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($statut->statut) {
            $statut->statut->delete();
        }

        return (new StatutResource($statut))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Statut $statut)
    {
        abort_if(Gate::denies('statut_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statut->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
