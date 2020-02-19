<?php

namespace App\Http\Controllers\Admin;

use App\DeclarationTva;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDeclarationTvaRequest;
use App\Http\Requests\StoreDeclarationTvaRequest;
use App\Http\Requests\UpdateDeclarationTvaRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DeclarationTvaController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('declaration_tva_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $declarationTvas = DeclarationTva::all();

        return view('admin.declarationTvas.index', compact('declarationTvas'));
    }

    public function create()
    {
        abort_if(Gate::denies('declaration_tva_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.declarationTvas.create');
    }

    public function store(StoreDeclarationTvaRequest $request)
    {
        $declarationTva = DeclarationTva::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $declarationTva->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $declarationTva->id]);
        }

        return redirect()->route('admin.declaration-tvas.index');
    }

    public function edit(DeclarationTva $declarationTva)
    {
        abort_if(Gate::denies('declaration_tva_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.declarationTvas.edit', compact('declarationTva'));
    }

    public function update(UpdateDeclarationTvaRequest $request, DeclarationTva $declarationTva)
    {
        $declarationTva->update($request->all());

        if (count($declarationTva->statut) > 0) {
            foreach ($declarationTva->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $declarationTva->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $declarationTva->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.declaration-tvas.index');
    }

    public function show(DeclarationTva $declarationTva)
    {
        abort_if(Gate::denies('declaration_tva_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.declarationTvas.show', compact('declarationTva'));
    }

    public function destroy(DeclarationTva $declarationTva)
    {
        abort_if(Gate::denies('declaration_tva_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $declarationTva->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeclarationTvaRequest $request)
    {
        DeclarationTva::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('declaration_tva_create') && Gate::denies('declaration_tva_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DeclarationTva();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
