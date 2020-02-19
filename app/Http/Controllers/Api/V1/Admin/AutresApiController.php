<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Autre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAutreRequest;
use App\Http\Requests\UpdateAutreRequest;
use App\Http\Resources\Admin\AutreResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutresApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('autre_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutreResource(Autre::all());
    }

    public function store(StoreAutreRequest $request)
    {
        $autre = Autre::create($request->all());

        if ($request->input('autres', false)) {
            $autre->addMedia(storage_path('tmp/uploads/' . $request->input('autres')))->toMediaCollection('autres');
        }

        return (new AutreResource($autre))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Autre $autre)
    {
        abort_if(Gate::denies('autre_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutreResource($autre);
    }

    public function update(UpdateAutreRequest $request, Autre $autre)
    {
        $autre->update($request->all());

        if ($request->input('autres', false)) {
            if (!$autre->autres || $request->input('autres') !== $autre->autres->file_name) {
                $autre->addMedia(storage_path('tmp/uploads/' . $request->input('autres')))->toMediaCollection('autres');
            }
        } elseif ($autre->autres) {
            $autre->autres->delete();
        }

        return (new AutreResource($autre))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Autre $autre)
    {
        abort_if(Gate::denies('autre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autre->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
