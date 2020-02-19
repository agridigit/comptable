<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreListeDesMoyenRequest;
use App\Http\Requests\UpdateListeDesMoyenRequest;
use App\Http\Resources\Admin\ListeDesMoyenResource;
use App\ListeDesMoyen;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ListeDesMoyensApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('liste_des_moyen_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ListeDesMoyenResource(ListeDesMoyen::all());
    }

    public function store(StoreListeDesMoyenRequest $request)
    {
        $listeDesMoyen = ListeDesMoyen::create($request->all());

        if ($request->input('liste_des_moyens', false)) {
            $listeDesMoyen->addMedia(storage_path('tmp/uploads/' . $request->input('liste_des_moyens')))->toMediaCollection('liste_des_moyens');
        }

        return (new ListeDesMoyenResource($listeDesMoyen))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListeDesMoyen $listeDesMoyen)
    {
        abort_if(Gate::denies('liste_des_moyen_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ListeDesMoyenResource($listeDesMoyen);
    }

    public function update(UpdateListeDesMoyenRequest $request, ListeDesMoyen $listeDesMoyen)
    {
        $listeDesMoyen->update($request->all());

        if ($request->input('liste_des_moyens', false)) {
            if (!$listeDesMoyen->liste_des_moyens || $request->input('liste_des_moyens') !== $listeDesMoyen->liste_des_moyens->file_name) {
                $listeDesMoyen->addMedia(storage_path('tmp/uploads/' . $request->input('liste_des_moyens')))->toMediaCollection('liste_des_moyens');
            }
        } elseif ($listeDesMoyen->liste_des_moyens) {
            $listeDesMoyen->liste_des_moyens->delete();
        }

        return (new ListeDesMoyenResource($listeDesMoyen))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ListeDesMoyen $listeDesMoyen)
    {
        abort_if(Gate::denies('liste_des_moyen_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listeDesMoyen->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
