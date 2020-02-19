<?php

namespace App\Http\Controllers\Admin;

use App\AutorisationDactivite;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAutorisationDactiviteRequest;
use App\Http\Requests\StoreAutorisationDactiviteRequest;
use App\Http\Requests\UpdateAutorisationDactiviteRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AutorisationDactiviteController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('autorisation_dactivite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autorisationDactivites = AutorisationDactivite::all();

        return view('admin.autorisationDactivites.index', compact('autorisationDactivites'));
    }

    public function create()
    {
        abort_if(Gate::denies('autorisation_dactivite_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autorisationDactivites.create');
    }

    public function store(StoreAutorisationDactiviteRequest $request)
    {
        $autorisationDactivite = AutorisationDactivite::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $autorisationDactivite->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $autorisationDactivite->id]);
        }

        return redirect()->route('admin.autorisation-dactivites.index');
    }

    public function edit(AutorisationDactivite $autorisationDactivite)
    {
        abort_if(Gate::denies('autorisation_dactivite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autorisationDactivites.edit', compact('autorisationDactivite'));
    }

    public function update(UpdateAutorisationDactiviteRequest $request, AutorisationDactivite $autorisationDactivite)
    {
        $autorisationDactivite->update($request->all());

        if (count($autorisationDactivite->statut) > 0) {
            foreach ($autorisationDactivite->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $autorisationDactivite->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $autorisationDactivite->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.autorisation-dactivites.index');
    }

    public function show(AutorisationDactivite $autorisationDactivite)
    {
        abort_if(Gate::denies('autorisation_dactivite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autorisationDactivites.show', compact('autorisationDactivite'));
    }

    public function destroy(AutorisationDactivite $autorisationDactivite)
    {
        abort_if(Gate::denies('autorisation_dactivite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autorisationDactivite->delete();

        return back();
    }

    public function massDestroy(MassDestroyAutorisationDactiviteRequest $request)
    {
        AutorisationDactivite::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('autorisation_dactivite_create') && Gate::denies('autorisation_dactivite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AutorisationDactivite();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
