<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Balance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\UpdateBalanceRequest;
use App\Http\Resources\Admin\BalanceResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BalanceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BalanceResource(Balance::all());
    }

    public function store(StoreBalanceRequest $request)
    {
        $balance = Balance::create($request->all());

        if ($request->input('balance', false)) {
            $balance->addMedia(storage_path('tmp/uploads/' . $request->input('balance')))->toMediaCollection('balance');
        }

        return (new BalanceResource($balance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Balance $balance)
    {
        abort_if(Gate::denies('balance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BalanceResource($balance);
    }

    public function update(UpdateBalanceRequest $request, Balance $balance)
    {
        $balance->update($request->all());

        if ($request->input('balance', false)) {
            if (!$balance->balance || $request->input('balance') !== $balance->balance->file_name) {
                $balance->addMedia(storage_path('tmp/uploads/' . $request->input('balance')))->toMediaCollection('balance');
            }
        } elseif ($balance->balance) {
            $balance->balance->delete();
        }

        return (new BalanceResource($balance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Balance $balance)
    {
        abort_if(Gate::denies('balance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
