<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPvPouvoirRequest;
use App\Http\Requests\StorePvPouvoirRequest;
use App\Http\Requests\UpdatePvPouvoirRequest;
use App\PvPouvoir;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PvPouvoirController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('pv_pouvoir_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pvPouvoirs = PvPouvoir::all();

        return view('admin.pvPouvoirs.index', compact('pvPouvoirs'));
    }

    public function create()
    {
        abort_if(Gate::denies('pv_pouvoir_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pvPouvoirs.create');
    }

    public function store(StorePvPouvoirRequest $request)
    {
        $pvPouvoir = PvPouvoir::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $pvPouvoir->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $pvPouvoir->id]);
        }

        return redirect()->route('admin.pv-pouvoirs.index');
    }

    public function edit(PvPouvoir $pvPouvoir)
    {
        abort_if(Gate::denies('pv_pouvoir_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pvPouvoirs.edit', compact('pvPouvoir'));
    }

    public function update(UpdatePvPouvoirRequest $request, PvPouvoir $pvPouvoir)
    {
        $pvPouvoir->update($request->all());

        if (count($pvPouvoir->statut) > 0) {
            foreach ($pvPouvoir->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $pvPouvoir->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $pvPouvoir->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.pv-pouvoirs.index');
    }

    public function show(PvPouvoir $pvPouvoir)
    {
        abort_if(Gate::denies('pv_pouvoir_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pvPouvoirs.show', compact('pvPouvoir'));
    }

    public function destroy(PvPouvoir $pvPouvoir)
    {
        abort_if(Gate::denies('pv_pouvoir_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pvPouvoir->delete();

        return back();
    }

    public function massDestroy(MassDestroyPvPouvoirRequest $request)
    {
        PvPouvoir::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('pv_pouvoir_create') && Gate::denies('pv_pouvoir_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PvPouvoir();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
