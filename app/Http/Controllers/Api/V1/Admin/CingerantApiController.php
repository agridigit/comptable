<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Cingerant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCingerantRequest;
use App\Http\Requests\UpdateCingerantRequest;
use App\Http\Resources\Admin\CingerantResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CingerantApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cingerant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CingerantResource(Cingerant::all());
    }

    public function store(StoreCingerantRequest $request)
    {
        $cingerant = Cingerant::create($request->all());

        if ($request->input('statut', false)) {
            $cingerant->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new CingerantResource($cingerant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Cingerant $cingerant)
    {
        abort_if(Gate::denies('cingerant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CingerantResource($cingerant);
    }

    public function update(UpdateCingerantRequest $request, Cingerant $cingerant)
    {
        $cingerant->update($request->all());

        if ($request->input('statut', false)) {
            if (!$cingerant->statut || $request->input('statut') !== $cingerant->statut->file_name) {
                $cingerant->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($cingerant->statut) {
            $cingerant->statut->delete();
        }

        return (new CingerantResource($cingerant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Cingerant $cingerant)
    {
        abort_if(Gate::denies('cingerant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cingerant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
