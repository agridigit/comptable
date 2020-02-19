<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPvTribunalRequest;
use App\Http\Requests\StorePvTribunalRequest;
use App\Http\Requests\UpdatePvTribunalRequest;
use App\PvTribunal;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PvTribunalController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('pv_tribunal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pvTribunals = PvTribunal::all();

        return view('admin.pvTribunals.index', compact('pvTribunals'));
    }

    public function create()
    {
        abort_if(Gate::denies('pv_tribunal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pvTribunals.create');
    }

    public function store(StorePvTribunalRequest $request)
    {
        $pvTribunal = PvTribunal::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $pvTribunal->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $pvTribunal->id]);
        }

        return redirect()->route('admin.pv-tribunals.index');
    }

    public function edit(PvTribunal $pvTribunal)
    {
        abort_if(Gate::denies('pv_tribunal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pvTribunals.edit', compact('pvTribunal'));
    }

    public function update(UpdatePvTribunalRequest $request, PvTribunal $pvTribunal)
    {
        $pvTribunal->update($request->all());

        if (count($pvTribunal->statut) > 0) {
            foreach ($pvTribunal->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $pvTribunal->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $pvTribunal->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.pv-tribunals.index');
    }

    public function show(PvTribunal $pvTribunal)
    {
        abort_if(Gate::denies('pv_tribunal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pvTribunals.show', compact('pvTribunal'));
    }

    public function destroy(PvTribunal $pvTribunal)
    {
        abort_if(Gate::denies('pv_tribunal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pvTribunal->delete();

        return back();
    }

    public function massDestroy(MassDestroyPvTribunalRequest $request)
    {
        PvTribunal::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('pv_tribunal_create') && Gate::denies('pv_tribunal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PvTribunal();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
