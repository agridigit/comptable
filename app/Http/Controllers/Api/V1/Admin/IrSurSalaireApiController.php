<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreIrSurSalaireRequest;
use App\Http\Requests\UpdateIrSurSalaireRequest;
use App\Http\Resources\Admin\IrSurSalaireResource;
use App\IrSurSalaire;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IrSurSalaireApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ir_sur_salaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IrSurSalaireResource(IrSurSalaire::all());
    }

    public function store(StoreIrSurSalaireRequest $request)
    {
        $irSurSalaire = IrSurSalaire::create($request->all());

        if ($request->input('statut', false)) {
            $irSurSalaire->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new IrSurSalaireResource($irSurSalaire))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(IrSurSalaire $irSurSalaire)
    {
        abort_if(Gate::denies('ir_sur_salaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IrSurSalaireResource($irSurSalaire);
    }

    public function update(UpdateIrSurSalaireRequest $request, IrSurSalaire $irSurSalaire)
    {
        $irSurSalaire->update($request->all());

        if ($request->input('statut', false)) {
            if (!$irSurSalaire->statut || $request->input('statut') !== $irSurSalaire->statut->file_name) {
                $irSurSalaire->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($irSurSalaire->statut) {
            $irSurSalaire->statut->delete();
        }

        return (new IrSurSalaireResource($irSurSalaire))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(IrSurSalaire $irSurSalaire)
    {
        abort_if(Gate::denies('ir_sur_salaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $irSurSalaire->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
