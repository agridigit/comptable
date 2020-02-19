<?php

namespace App\Http\Controllers\Admin;

use App\AutreDocument;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAutreDocumentRequest;
use App\Http\Requests\StoreAutreDocumentRequest;
use App\Http\Requests\UpdateAutreDocumentRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AutreDocumentsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('autre_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autreDocuments = AutreDocument::all();

        return view('admin.autreDocuments.index', compact('autreDocuments'));
    }

    public function create()
    {
        abort_if(Gate::denies('autre_document_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autreDocuments.create');
    }

    public function store(StoreAutreDocumentRequest $request)
    {
        $autreDocument = AutreDocument::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $autreDocument->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $autreDocument->id]);
        }

        return redirect()->route('admin.autre-documents.index');
    }

    public function edit(AutreDocument $autreDocument)
    {
        abort_if(Gate::denies('autre_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autreDocuments.edit', compact('autreDocument'));
    }

    public function update(UpdateAutreDocumentRequest $request, AutreDocument $autreDocument)
    {
        $autreDocument->update($request->all());

        if (count($autreDocument->statut) > 0) {
            foreach ($autreDocument->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $autreDocument->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $autreDocument->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.autre-documents.index');
    }

    public function show(AutreDocument $autreDocument)
    {
        abort_if(Gate::denies('autre_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autreDocuments.show', compact('autreDocument'));
    }

    public function destroy(AutreDocument $autreDocument)
    {
        abort_if(Gate::denies('autre_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autreDocument->delete();

        return back();
    }

    public function massDestroy(MassDestroyAutreDocumentRequest $request)
    {
        AutreDocument::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('autre_document_create') && Gate::denies('autre_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AutreDocument();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
