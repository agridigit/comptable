<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Bilan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBilanRequest;
use App\Http\Requests\UpdateBilanRequest;
use App\Http\Resources\Admin\BilanResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BilanApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('bilan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BilanResource(Bilan::all());
    }

    public function store(StoreBilanRequest $request)
    {
        $bilan = Bilan::create($request->all());

        if ($request->input('statut', false)) {
            $bilan->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new BilanResource($bilan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Bilan $bilan)
    {
        abort_if(Gate::denies('bilan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BilanResource($bilan);
    }

    public function update(UpdateBilanRequest $request, Bilan $bilan)
    {
        $bilan->update($request->all());

        if ($request->input('statut', false)) {
            if (!$bilan->statut || $request->input('statut') !== $bilan->statut->file_name) {
                $bilan->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($bilan->statut) {
            $bilan->statut->delete();
        }

        return (new BilanResource($bilan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Bilan $bilan)
    {
        abort_if(Gate::denies('bilan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bilan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
