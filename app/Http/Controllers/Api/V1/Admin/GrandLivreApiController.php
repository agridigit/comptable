<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\GrandLivre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreGrandLivreRequest;
use App\Http\Requests\UpdateGrandLivreRequest;
use App\Http\Resources\Admin\GrandLivreResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GrandLivreApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('grand_livre_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GrandLivreResource(GrandLivre::all());
    }

    public function store(StoreGrandLivreRequest $request)
    {
        $grandLivre = GrandLivre::create($request->all());

        if ($request->input('grand_livre', false)) {
            $grandLivre->addMedia(storage_path('tmp/uploads/' . $request->input('grand_livre')))->toMediaCollection('grand_livre');
        }

        return (new GrandLivreResource($grandLivre))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(GrandLivre $grandLivre)
    {
        abort_if(Gate::denies('grand_livre_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GrandLivreResource($grandLivre);
    }

    public function update(UpdateGrandLivreRequest $request, GrandLivre $grandLivre)
    {
        $grandLivre->update($request->all());

        if ($request->input('grand_livre', false)) {
            if (!$grandLivre->grand_livre || $request->input('grand_livre') !== $grandLivre->grand_livre->file_name) {
                $grandLivre->addMedia(storage_path('tmp/uploads/' . $request->input('grand_livre')))->toMediaCollection('grand_livre');
            }
        } elseif ($grandLivre->grand_livre) {
            $grandLivre->grand_livre->delete();
        }

        return (new GrandLivreResource($grandLivre))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(GrandLivre $grandLivre)
    {
        abort_if(Gate::denies('grand_livre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grandLivre->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
