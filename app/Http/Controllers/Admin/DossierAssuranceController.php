<?php

namespace App\Http\Controllers\Admin;

use App\DossierAssurance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDossierAssuranceRequest;
use App\Http\Requests\StoreDossierAssuranceRequest;
use App\Http\Requests\UpdateDossierAssuranceRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DossierAssuranceController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('dossier_assurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dossierAssurances = DossierAssurance::all();

        return view('admin.dossierAssurances.index', compact('dossierAssurances'));
    }

    public function create()
    {
        abort_if(Gate::denies('dossier_assurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dossierAssurances.create');
    }

    public function store(StoreDossierAssuranceRequest $request)
    {
        $dossierAssurance = DossierAssurance::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $dossierAssurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dossierAssurance->id]);
        }

        return redirect()->route('admin.dossier-assurances.index');
    }

    public function edit(DossierAssurance $dossierAssurance)
    {
        abort_if(Gate::denies('dossier_assurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dossierAssurances.edit', compact('dossierAssurance'));
    }

    public function update(UpdateDossierAssuranceRequest $request, DossierAssurance $dossierAssurance)
    {
        $dossierAssurance->update($request->all());

        if (count($dossierAssurance->statut) > 0) {
            foreach ($dossierAssurance->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $dossierAssurance->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $dossierAssurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.dossier-assurances.index');
    }

    public function show(DossierAssurance $dossierAssurance)
    {
        abort_if(Gate::denies('dossier_assurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dossierAssurances.show', compact('dossierAssurance'));
    }

    public function destroy(DossierAssurance $dossierAssurance)
    {
        abort_if(Gate::denies('dossier_assurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dossierAssurance->delete();

        return back();
    }

    public function massDestroy(MassDestroyDossierAssuranceRequest $request)
    {
        DossierAssurance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('dossier_assurance_create') && Gate::denies('dossier_assurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DossierAssurance();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
