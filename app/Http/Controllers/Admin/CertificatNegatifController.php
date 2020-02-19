<?php

namespace App\Http\Controllers\Admin;

use App\CertificatNegatif;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCertificatNegatifRequest;
use App\Http\Requests\StoreCertificatNegatifRequest;
use App\Http\Requests\UpdateCertificatNegatifRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CertificatNegatifController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('certificat_negatif_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $certificatNegatifs = CertificatNegatif::all();

        return view('admin.certificatNegatifs.index', compact('certificatNegatifs'));
    }

    public function create()
    {
        abort_if(Gate::denies('certificat_negatif_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.certificatNegatifs.create');
    }

    public function store(StoreCertificatNegatifRequest $request)
    {
        $certificatNegatif = CertificatNegatif::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $certificatNegatif->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $certificatNegatif->id]);
        }

        return redirect()->route('admin.certificat-negatifs.index');
    }

    public function edit(CertificatNegatif $certificatNegatif)
    {
        abort_if(Gate::denies('certificat_negatif_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.certificatNegatifs.edit', compact('certificatNegatif'));
    }

    public function update(UpdateCertificatNegatifRequest $request, CertificatNegatif $certificatNegatif)
    {
        $certificatNegatif->update($request->all());

        if (count($certificatNegatif->statut) > 0) {
            foreach ($certificatNegatif->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $certificatNegatif->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $certificatNegatif->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.certificat-negatifs.index');
    }

    public function show(CertificatNegatif $certificatNegatif)
    {
        abort_if(Gate::denies('certificat_negatif_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.certificatNegatifs.show', compact('certificatNegatif'));
    }

    public function destroy(CertificatNegatif $certificatNegatif)
    {
        abort_if(Gate::denies('certificat_negatif_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $certificatNegatif->delete();

        return back();
    }

    public function massDestroy(MassDestroyCertificatNegatifRequest $request)
    {
        CertificatNegatif::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('certificat_negatif_create') && Gate::denies('certificat_negatif_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CertificatNegatif();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
