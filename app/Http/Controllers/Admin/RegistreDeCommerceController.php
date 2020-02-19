<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRegistreDeCommerceRequest;
use App\Http\Requests\StoreRegistreDeCommerceRequest;
use App\Http\Requests\UpdateRegistreDeCommerceRequest;
use App\RegistreDeCommerce;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RegistreDeCommerceController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('registre_de_commerce_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $registreDeCommerces = RegistreDeCommerce::all();

        return view('admin.registreDeCommerces.index', compact('registreDeCommerces'));
    }

    public function create()
    {
        abort_if(Gate::denies('registre_de_commerce_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.registreDeCommerces.create');
    }

    public function store(StoreRegistreDeCommerceRequest $request)
    {
        $registreDeCommerce = RegistreDeCommerce::create($request->all());

        foreach ($request->input('statut', []) as $file) {
            $registreDeCommerce->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $registreDeCommerce->id]);
        }

        return redirect()->route('admin.registre-de-commerces.index');
    }

    public function edit(RegistreDeCommerce $registreDeCommerce)
    {
        abort_if(Gate::denies('registre_de_commerce_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.registreDeCommerces.edit', compact('registreDeCommerce'));
    }

    public function update(UpdateRegistreDeCommerceRequest $request, RegistreDeCommerce $registreDeCommerce)
    {
        $registreDeCommerce->update($request->all());

        if (count($registreDeCommerce->statut) > 0) {
            foreach ($registreDeCommerce->statut as $media) {
                if (!in_array($media->file_name, $request->input('statut', []))) {
                    $media->delete();
                }
            }
        }

        $media = $registreDeCommerce->statut->pluck('file_name')->toArray();

        foreach ($request->input('statut', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $registreDeCommerce->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('statut');
            }
        }

        return redirect()->route('admin.registre-de-commerces.index');
    }

    public function show(RegistreDeCommerce $registreDeCommerce)
    {
        abort_if(Gate::denies('registre_de_commerce_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.registreDeCommerces.show', compact('registreDeCommerce'));
    }

    public function destroy(RegistreDeCommerce $registreDeCommerce)
    {
        abort_if(Gate::denies('registre_de_commerce_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $registreDeCommerce->delete();

        return back();
    }

    public function massDestroy(MassDestroyRegistreDeCommerceRequest $request)
    {
        RegistreDeCommerce::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('registre_de_commerce_create') && Gate::denies('registre_de_commerce_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new RegistreDeCommerce();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
