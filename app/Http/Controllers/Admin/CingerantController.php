<?php

namespace App\Http\Controllers\Admin;

use App\Cingerant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCingerantRequest;
use App\Http\Requests\StoreCingerantRequest;
use App\Http\Requests\UpdateCingerantRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CingerantController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('cingerant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cingerants = Cingerant::all();

        return view('admin.cingerants.index', compact('cingerants'));
    }

    public function create()
    {
        abort_if(Gate::denies('cingerant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cingerants.create');
    }

    public function store(StoreCingerantRequest $request)
    {
        $cingerant = Cingerant::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $cingerant->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cingerant->id]);
        }

        return redirect()->route('admin.cingerants.index');
    }

    public function edit(Cingerant $cingerant)
    {
        abort_if(Gate::denies('cingerant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cingerants.edit', compact('cingerant'));
    }

    public function update(UpdateCingerantRequest $request, Cingerant $cingerant)
    {
        $cingerant->update($request->all());

        if (count($cingerant->statut) > 0) {
            foreach ($cingerant->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $cingerant->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cingerant->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.cingerants.index');
    }

    public function show(Cingerant $cingerant)
    {
        abort_if(Gate::denies('cingerant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cingerants.show', compact('cingerant'));
    }

    public function destroy(Cingerant $cingerant)
    {
        abort_if(Gate::denies('cingerant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cingerant->delete();

        return back();
    }

    public function massDestroy(MassDestroyCingerantRequest $request)
    {
        Cingerant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cingerant_create') && Gate::denies('cingerant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Cingerant();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
