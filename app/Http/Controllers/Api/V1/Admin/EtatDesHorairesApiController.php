<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\EtatDesHoraire;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEtatDesHoraireRequest;
use App\Http\Requests\UpdateEtatDesHoraireRequest;
use App\Http\Resources\Admin\EtatDesHoraireResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EtatDesHorairesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('etat_des_horaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EtatDesHoraireResource(EtatDesHoraire::all());
    }

    public function store(StoreEtatDesHoraireRequest $request)
    {
        $etatDesHoraire = EtatDesHoraire::create($request->all());

        if ($request->input('etat_des_horaires', false)) {
            $etatDesHoraire->addMedia(storage_path('tmp/uploads/' . $request->input('etat_des_horaires')))->toMediaCollection('etat_des_horaires');
        }

        return (new EtatDesHoraireResource($etatDesHoraire))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EtatDesHoraire $etatDesHoraire)
    {
        abort_if(Gate::denies('etat_des_horaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EtatDesHoraireResource($etatDesHoraire);
    }

    public function update(UpdateEtatDesHoraireRequest $request, EtatDesHoraire $etatDesHoraire)
    {
        $etatDesHoraire->update($request->all());

        if ($request->input('etat_des_horaires', false)) {
            if (!$etatDesHoraire->etat_des_horaires || $request->input('etat_des_horaires') !== $etatDesHoraire->etat_des_horaires->file_name) {
                $etatDesHoraire->addMedia(storage_path('tmp/uploads/' . $request->input('etat_des_horaires')))->toMediaCollection('etat_des_horaires');
            }
        } elseif ($etatDesHoraire->etat_des_horaires) {
            $etatDesHoraire->etat_des_horaires->delete();
        }

        return (new EtatDesHoraireResource($etatDesHoraire))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EtatDesHoraire $etatDesHoraire)
    {
        abort_if(Gate::denies('etat_des_horaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $etatDesHoraire->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
