<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyIrSurSalaireRequest;
use App\Http\Requests\StoreIrSurSalaireRequest;
use App\Http\Requests\UpdateIrSurSalaireRequest;
use App\IrSurSalaire;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class IrSurSalaireController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('ir_sur_salaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $irSurSalaires = IrSurSalaire::all();

        return view('admin.irSurSalaires.index', compact('irSurSalaires'));
    }

    public function create()
    {
        abort_if(Gate::denies('ir_sur_salaire_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.irSurSalaires.create');
    }

    public function store(StoreIrSurSalaireRequest $request)
    {
        $irSurSalaire = IrSurSalaire::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $irSurSalaire->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $irSurSalaire->id]);
        }

        return redirect()->route('admin.ir-sur-salaires.index');
    }

    public function edit(IrSurSalaire $irSurSalaire)
    {
        abort_if(Gate::denies('ir_sur_salaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.irSurSalaires.edit', compact('irSurSalaire'));
    }

    public function update(UpdateIrSurSalaireRequest $request, IrSurSalaire $irSurSalaire)
    {
        $irSurSalaire->update($request->all());

        if (count($irSurSalaire->statut) > 0) {
            foreach ($irSurSalaire->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $irSurSalaire->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $irSurSalaire->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.ir-sur-salaires.index');
    }

    public function show(IrSurSalaire $irSurSalaire)
    {
        abort_if(Gate::denies('ir_sur_salaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.irSurSalaires.show', compact('irSurSalaire'));
    }

    public function destroy(IrSurSalaire $irSurSalaire)
    {
        abort_if(Gate::denies('ir_sur_salaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $irSurSalaire->delete();

        return back();
    }

    public function massDestroy(MassDestroyIrSurSalaireRequest $request)
    {
        IrSurSalaire::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('ir_sur_salaire_create') && Gate::denies('ir_sur_salaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new IrSurSalaire();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
