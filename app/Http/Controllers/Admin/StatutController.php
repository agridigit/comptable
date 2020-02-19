<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStatutRequest;
use App\Http\Requests\StoreStatutRequest;
use App\Http\Requests\UpdateStatutRequest;
use App\Statut;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class StatutController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('statut_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuts = Statut::all();

        return view('admin.statuts.index', compact('statuts'));
    }

    public function create()
    {
        abort_if(Gate::denies('statut_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.statuts.create');
    }

    public function store(StoreStatutRequest $request)
    {
        $statut = Statut::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $statut->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $statut->id]);
        }

        return redirect()->route('admin.statuts.index');
    }

    public function edit(Statut $statut)
    {
        abort_if(Gate::denies('statut_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.statuts.edit', compact('statut'));
    }

    public function update(UpdateStatutRequest $request, Statut $statut)
    {
        $statut->update($request->all());

        if (count($statut->statut) > 0) {
            foreach ($statut->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $statut->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $statut->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.statuts.index');
    }

    public function show(Statut $statut)
    {
        abort_if(Gate::denies('statut_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.statuts.show', compact('statut'));
    }

    public function destroy(Statut $statut)
    {
        abort_if(Gate::denies('statut_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statut->delete();

        return back();
    }

    public function massDestroy(MassDestroyStatutRequest $request)
    {
        Statut::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('statut_create') && Gate::denies('statut_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Statut();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
