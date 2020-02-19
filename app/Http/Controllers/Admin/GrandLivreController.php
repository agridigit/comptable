<?php

namespace App\Http\Controllers\Admin;

use App\GrandLivre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyGrandLivreRequest;
use App\Http\Requests\StoreGrandLivreRequest;
use App\Http\Requests\UpdateGrandLivreRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class GrandLivreController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('grand_livre_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grandLivres = GrandLivre::all();

        return view('admin.grandLivres.index', compact('grandLivres'));
    }

    public function create()
    {
        abort_if(Gate::denies('grand_livre_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.grandLivres.create');
    }

    public function store(StoreGrandLivreRequest $request)
    {
        $grandLivre = GrandLivre::create($request->all());

        foreach ($request->input('grand_livre', []) as $file) {
            $grandLivre->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('grand_livre');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $grandLivre->id]);
        }

        return redirect()->route('admin.grand-livres.index');
    }

    public function edit(GrandLivre $grandLivre)
    {
        abort_if(Gate::denies('grand_livre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.grandLivres.edit', compact('grandLivre'));
    }

    public function update(UpdateGrandLivreRequest $request, GrandLivre $grandLivre)
    {
        $grandLivre->update($request->all());

        if (count($grandLivre->grand_livre) > 0) {
            foreach ($grandLivre->grand_livre as $media) {
                if (!in_array($media->file_name, $request->input('grand_livre', []))) {
                    $media->delete();
                }
            }
        }

        $media = $grandLivre->grand_livre->pluck('file_name')->toArray();

        foreach ($request->input('grand_livre', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $grandLivre->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('grand_livre');
            }
        }

        return redirect()->route('admin.grand-livres.index');
    }

    public function show(GrandLivre $grandLivre)
    {
        abort_if(Gate::denies('grand_livre_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.grandLivres.show', compact('grandLivre'));
    }

    public function destroy(GrandLivre $grandLivre)
    {
        abort_if(Gate::denies('grand_livre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grandLivre->delete();

        return back();
    }

    public function massDestroy(MassDestroyGrandLivreRequest $request)
    {
        GrandLivre::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('grand_livre_create') && Gate::denies('grand_livre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new GrandLivre();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
