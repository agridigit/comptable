<?php

namespace App\Http\Controllers\Admin;

use App\EtatDesHoraire;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEtatDesHoraireRequest;
use App\Http\Requests\StoreEtatDesHoraireRequest;
use App\Http\Requests\UpdateEtatDesHoraireRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EtatDesHorairesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('etat_des_horaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $etatDesHoraires = EtatDesHoraire::all();

        return view('admin.etatDesHoraires.index', compact('etatDesHoraires'));
    }

    public function create()
    {
        abort_if(Gate::denies('etat_des_horaire_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.etatDesHoraires.create');
    }

    public function store(StoreEtatDesHoraireRequest $request)
    {
        $etatDesHoraire = EtatDesHoraire::create($request->all());

        foreach ($request->input('etat_des_horaires', []) as $file) {
            $etatDesHoraire->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('etat_des_horaires');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $etatDesHoraire->id]);
        }

        return redirect()->route('admin.etat-des-horaires.index');
    }

    public function edit(EtatDesHoraire $etatDesHoraire)
    {
        abort_if(Gate::denies('etat_des_horaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.etatDesHoraires.edit', compact('etatDesHoraire'));
    }

    public function update(UpdateEtatDesHoraireRequest $request, EtatDesHoraire $etatDesHoraire)
    {
        $etatDesHoraire->update($request->all());

        if (count($etatDesHoraire->etat_des_horaires) > 0) {
            foreach ($etatDesHoraire->etat_des_horaires as $media) {
                if (!in_array($media->file_name, $request->input('etat_des_horaires', []))) {
                    $media->delete();
                }
            }
        }

        $media = $etatDesHoraire->etat_des_horaires->pluck('file_name')->toArray();

        foreach ($request->input('etat_des_horaires', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $etatDesHoraire->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('etat_des_horaires');
            }
        }

        return redirect()->route('admin.etat-des-horaires.index');
    }

    public function show(EtatDesHoraire $etatDesHoraire)
    {
        abort_if(Gate::denies('etat_des_horaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.etatDesHoraires.show', compact('etatDesHoraire'));
    }

    public function destroy(EtatDesHoraire $etatDesHoraire)
    {
        abort_if(Gate::denies('etat_des_horaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $etatDesHoraire->delete();

        return back();
    }

    public function massDestroy(MassDestroyEtatDesHoraireRequest $request)
    {
        EtatDesHoraire::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('etat_des_horaire_create') && Gate::denies('etat_des_horaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EtatDesHoraire();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
