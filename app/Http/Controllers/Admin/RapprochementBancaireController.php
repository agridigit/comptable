<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRapprochementBancaireRequest;
use App\Http\Requests\StoreRapprochementBancaireRequest;
use App\Http\Requests\UpdateRapprochementBancaireRequest;
use App\RapprochementBancaire;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RapprochementBancaireController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('rapprochement_bancaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rapprochementBancaires = RapprochementBancaire::all();

        return view('admin.rapprochementBancaires.index', compact('rapprochementBancaires'));
    }

    public function create()
    {
        abort_if(Gate::denies('rapprochement_bancaire_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rapprochementBancaires.create');
    }

    public function store(StoreRapprochementBancaireRequest $request)
    {
        $rapprochementBancaire = RapprochementBancaire::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $rapprochementBancaire->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $rapprochementBancaire->id]);
        }

        return redirect()->route('admin.rapprochement-bancaires.index');
    }

    public function edit(RapprochementBancaire $rapprochementBancaire)
    {
        abort_if(Gate::denies('rapprochement_bancaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rapprochementBancaires.edit', compact('rapprochementBancaire'));
    }

    public function update(UpdateRapprochementBancaireRequest $request, RapprochementBancaire $rapprochementBancaire)
    {
        $rapprochementBancaire->update($request->all());

        if (count($rapprochementBancaire->statut) > 0) {
            foreach ($rapprochementBancaire->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $rapprochementBancaire->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $rapprochementBancaire->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.rapprochement-bancaires.index');
    }

    public function show(RapprochementBancaire $rapprochementBancaire)
    {
        abort_if(Gate::denies('rapprochement_bancaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rapprochementBancaires.show', compact('rapprochementBancaire'));
    }

    public function destroy(RapprochementBancaire $rapprochementBancaire)
    {
        abort_if(Gate::denies('rapprochement_bancaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rapprochementBancaire->delete();

        return back();
    }

    public function massDestroy(MassDestroyRapprochementBancaireRequest $request)
    {
        RapprochementBancaire::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('rapprochement_bancaire_create') && Gate::denies('rapprochement_bancaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new RapprochementBancaire();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
