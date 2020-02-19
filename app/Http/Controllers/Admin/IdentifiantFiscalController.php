<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyIdentifiantFiscalRequest;
use App\Http\Requests\StoreIdentifiantFiscalRequest;
use App\Http\Requests\UpdateIdentifiantFiscalRequest;
use App\IdentifiantFiscal;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class IdentifiantFiscalController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('identifiant_fiscal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $identifiantFiscals = IdentifiantFiscal::all();

        return view('admin.identifiantFiscals.index', compact('identifiantFiscals'));
    }

    public function create()
    {
        abort_if(Gate::denies('identifiant_fiscal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.identifiantFiscals.create');
    }

    public function store(StoreIdentifiantFiscalRequest $request)
    {
        $identifiantFiscal = IdentifiantFiscal::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $identifiantFiscal->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $identifiantFiscal->id]);
        }

        return redirect()->route('admin.identifiant-fiscals.index');
    }

    public function edit(IdentifiantFiscal $identifiantFiscal)
    {
        abort_if(Gate::denies('identifiant_fiscal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.identifiantFiscals.edit', compact('identifiantFiscal'));
    }

    public function update(UpdateIdentifiantFiscalRequest $request, IdentifiantFiscal $identifiantFiscal)
    {
        $identifiantFiscal->update($request->all());

        if (count($identifiantFiscal->statut) > 0) {
            foreach ($identifiantFiscal->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $identifiantFiscal->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $identifiantFiscal->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.identifiant-fiscals.index');
    }

    public function show(IdentifiantFiscal $identifiantFiscal)
    {
        abort_if(Gate::denies('identifiant_fiscal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.identifiantFiscals.show', compact('identifiantFiscal'));
    }

    public function destroy(IdentifiantFiscal $identifiantFiscal)
    {
        abort_if(Gate::denies('identifiant_fiscal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $identifiantFiscal->delete();

        return back();
    }

    public function massDestroy(MassDestroyIdentifiantFiscalRequest $request)
    {
        IdentifiantFiscal::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('identifiant_fiscal_create') && Gate::denies('identifiant_fiscal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new IdentifiantFiscal();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
