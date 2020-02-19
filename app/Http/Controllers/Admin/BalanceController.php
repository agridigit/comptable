<?php

namespace App\Http\Controllers\Admin;

use App\Balance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBalanceRequest;
use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\UpdateBalanceRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BalanceController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balances = Balance::all();

        return view('admin.balances.index', compact('balances'));
    }

    public function create()
    {
        abort_if(Gate::denies('balance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.balances.create');
    }

    public function store(StoreBalanceRequest $request)
    {
        $balance = Balance::create($request->all());

        foreach ($request->input('balance', []) as $file) {
            $balance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('balance');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $balance->id]);
        }

        return redirect()->route('admin.balances.index');
    }

    public function edit(Balance $balance)
    {
        abort_if(Gate::denies('balance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.balances.edit', compact('balance'));
    }

    public function update(UpdateBalanceRequest $request, Balance $balance)
    {
        $balance->update($request->all());

        if (count($balance->balance) > 0) {
            foreach ($balance->balance as $media) {
                if (!in_array($media->file_name, $request->input('balance', []))) {
                    $media->delete();
                }
            }
        }

        $media = $balance->balance->pluck('file_name')->toArray();

        foreach ($request->input('balance', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $balance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('balance');
            }
        }

        return redirect()->route('admin.balances.index');
    }

    public function show(Balance $balance)
    {
        abort_if(Gate::denies('balance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.balances.show', compact('balance'));
    }

    public function destroy(Balance $balance)
    {
        abort_if(Gate::denies('balance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->delete();

        return back();
    }

    public function massDestroy(MassDestroyBalanceRequest $request)
    {
        Balance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('balance_create') && Gate::denies('balance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Balance();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
