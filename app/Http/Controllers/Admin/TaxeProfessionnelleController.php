<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTaxeProfessionnelleRequest;
use App\Http\Requests\StoreTaxeProfessionnelleRequest;
use App\Http\Requests\UpdateTaxeProfessionnelleRequest;
use App\TaxeProfessionnelle;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TaxeProfessionnelleController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('taxe_professionnelle_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taxeProfessionnelles = TaxeProfessionnelle::all();

        return view('admin.taxeProfessionnelles.index', compact('taxeProfessionnelles'));
    }

    public function create()
    {
        abort_if(Gate::denies('taxe_professionnelle_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taxeProfessionnelles.create');
    }

    public function store(StoreTaxeProfessionnelleRequest $request)
    {
        $taxeProfessionnelle = TaxeProfessionnelle::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $taxeProfessionnelle->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $taxeProfessionnelle->id]);
        }

        return redirect()->route('admin.taxe-professionnelles.index');
    }

    public function edit(TaxeProfessionnelle $taxeProfessionnelle)
    {
        abort_if(Gate::denies('taxe_professionnelle_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taxeProfessionnelles.edit', compact('taxeProfessionnelle'));
    }

    public function update(UpdateTaxeProfessionnelleRequest $request, TaxeProfessionnelle $taxeProfessionnelle)
    {
        $taxeProfessionnelle->update($request->all());

        if (count($taxeProfessionnelle->statut) > 0) {
            foreach ($taxeProfessionnelle->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $taxeProfessionnelle->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $taxeProfessionnelle->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.taxe-professionnelles.index');
    }

    public function show(TaxeProfessionnelle $taxeProfessionnelle)
    {
        abort_if(Gate::denies('taxe_professionnelle_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taxeProfessionnelles.show', compact('taxeProfessionnelle'));
    }

    public function destroy(TaxeProfessionnelle $taxeProfessionnelle)
    {
        abort_if(Gate::denies('taxe_professionnelle_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taxeProfessionnelle->delete();

        return back();
    }

    public function massDestroy(MassDestroyTaxeProfessionnelleRequest $request)
    {
        TaxeProfessionnelle::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('taxe_professionnelle_create') && Gate::denies('taxe_professionnelle_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new TaxeProfessionnelle();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
