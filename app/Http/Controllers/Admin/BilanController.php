<?php

namespace App\Http\Controllers\Admin;

use App\Bilan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBilanRequest;
use App\Http\Requests\StoreBilanRequest;
use App\Http\Requests\UpdateBilanRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BilanController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('bilan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bilans = Bilan::all();

        return view('admin.bilans.index', compact('bilans'));
    }

    public function create()
    {
        abort_if(Gate::denies('bilan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bilans.create');
    }

    public function store(StoreBilanRequest $request)
    {
        $bilan = Bilan::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $bilan->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $bilan->id]);
        }

        return redirect()->route('admin.bilans.index');
    }

    public function edit(Bilan $bilan)
    {
        abort_if(Gate::denies('bilan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bilans.edit', compact('bilan'));
    }

    public function update(UpdateBilanRequest $request, Bilan $bilan)
    {
        $bilan->update($request->all());

        if (count($bilan->statut) > 0) {
            foreach ($bilan->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $bilan->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $bilan->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.bilans.index');
    }

    public function show(Bilan $bilan)
    {
        abort_if(Gate::denies('bilan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bilans.show', compact('bilan'));
    }

    public function destroy(Bilan $bilan)
    {
        abort_if(Gate::denies('bilan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bilan->delete();

        return back();
    }

    public function massDestroy(MassDestroyBilanRequest $request)
    {
        Bilan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('bilan_create') && Gate::denies('bilan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Bilan();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
