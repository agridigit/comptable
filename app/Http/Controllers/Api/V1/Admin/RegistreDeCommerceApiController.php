<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRegistreDeCommerceRequest;
use App\Http\Requests\UpdateRegistreDeCommerceRequest;
use App\Http\Resources\Admin\RegistreDeCommerceResource;
use App\RegistreDeCommerce;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistreDeCommerceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('registre_de_commerce_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RegistreDeCommerceResource(RegistreDeCommerce::all());
    }

    public function store(StoreRegistreDeCommerceRequest $request)
    {
        $registreDeCommerce = RegistreDeCommerce::create($request->all());

        if ($request->input('statut', false)) {
            $registreDeCommerce->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
        }

        return (new RegistreDeCommerceResource($registreDeCommerce))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RegistreDeCommerce $registreDeCommerce)
    {
        abort_if(Gate::denies('registre_de_commerce_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RegistreDeCommerceResource($registreDeCommerce);
    }

    public function update(UpdateRegistreDeCommerceRequest $request, RegistreDeCommerce $registreDeCommerce)
    {
        $registreDeCommerce->update($request->all());

        if ($request->input('statut', false)) {
            if (!$registreDeCommerce->statut || $request->input('statut') !== $registreDeCommerce->statut->file_name) {
                $registreDeCommerce->addMedia(storage_path('tmp/uploads/' . $request->input('statut')))->toMediaCollection('statut');
            }
        } elseif ($registreDeCommerce->statut) {
            $registreDeCommerce->statut->delete();
        }

        return (new RegistreDeCommerceResource($registreDeCommerce))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RegistreDeCommerce $registreDeCommerce)
    {
        abort_if(Gate::denies('registre_de_commerce_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $registreDeCommerce->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
