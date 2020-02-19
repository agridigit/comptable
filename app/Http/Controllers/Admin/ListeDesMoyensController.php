<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyListeDesMoyenRequest;
use App\Http\Requests\StoreListeDesMoyenRequest;
use App\Http\Requests\UpdateListeDesMoyenRequest;
use App\ListeDesMoyen;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ListeDesMoyensController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('liste_des_moyen_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listeDesMoyens = ListeDesMoyen::all();

        return view('admin.listeDesMoyens.index', compact('listeDesMoyens'));
    }

    public function create()
    {
        abort_if(Gate::denies('liste_des_moyen_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.listeDesMoyens.create');
    }

    public function store(StoreListeDesMoyenRequest $request)
    {
        $listeDesMoyen = ListeDesMoyen::create($request->all());

        foreach ($request->input('liste_des_moyens', []) as $file) {
            $listeDesMoyen->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('liste_des_moyens');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $listeDesMoyen->id]);
        }

        return redirect()->route('admin.liste-des-moyens.index');
    }

    public function edit(ListeDesMoyen $listeDesMoyen)
    {
        abort_if(Gate::denies('liste_des_moyen_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.listeDesMoyens.edit', compact('listeDesMoyen'));
    }

    public function update(UpdateListeDesMoyenRequest $request, ListeDesMoyen $listeDesMoyen)
    {
        $listeDesMoyen->update($request->all());

        if (count($listeDesMoyen->liste_des_moyens) > 0) {
            foreach ($listeDesMoyen->liste_des_moyens as $media) {
                if (!in_array($media->file_name, $request->input('liste_des_moyens', []))) {
                    $media->delete();
                }
            }
        }

        $media = $listeDesMoyen->liste_des_moyens->pluck('file_name')->toArray();

        foreach ($request->input('liste_des_moyens', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $listeDesMoyen->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('liste_des_moyens');
            }
        }

        return redirect()->route('admin.liste-des-moyens.index');
    }

    public function show(ListeDesMoyen $listeDesMoyen)
    {
        abort_if(Gate::denies('liste_des_moyen_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.listeDesMoyens.show', compact('listeDesMoyen'));
    }

    public function destroy(ListeDesMoyen $listeDesMoyen)
    {
        abort_if(Gate::denies('liste_des_moyen_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listeDesMoyen->delete();

        return back();
    }

    public function massDestroy(MassDestroyListeDesMoyenRequest $request)
    {
        ListeDesMoyen::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('liste_des_moyen_create') && Gate::denies('liste_des_moyen_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ListeDesMoyen();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
