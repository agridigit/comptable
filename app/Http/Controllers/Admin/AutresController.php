<?php

namespace App\Http\Controllers\Admin;

use App\Autre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAutreRequest;
use App\Http\Requests\StoreAutreRequest;
use App\Http\Requests\UpdateAutreRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AutresController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('autre_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autres = Autre::all();

        return view('admin.autres.index', compact('autres'));
    }

    public function create()
    {
        abort_if(Gate::denies('autre_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autres.create');
    }

    public function store(StoreAutreRequest $request)
    {
        $autre = Autre::create($request->all());

        foreach ($request->input('autres', []) as $file) {
            $autre->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('autres');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $autre->id]);
        }

        return redirect()->route('admin.autres.index');
    }

    public function edit(Autre $autre)
    {
        abort_if(Gate::denies('autre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autres.edit', compact('autre'));
    }

    public function update(UpdateAutreRequest $request, Autre $autre)
    {
        $autre->update($request->all());

        if (count($autre->autres) > 0) {
            foreach ($autre->autres as $media) {
                if (!in_array($media->file_name, $request->input('autres', []))) {
                    $media->delete();
                }
            }
        }

        $media = $autre->autres->pluck('file_name')->toArray();

        foreach ($request->input('autres', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $autre->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('autres');
            }
        }

        return redirect()->route('admin.autres.index');
    }

    public function show(Autre $autre)
    {
        abort_if(Gate::denies('autre_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.autres.show', compact('autre'));
    }

    public function destroy(Autre $autre)
    {
        abort_if(Gate::denies('autre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autre->delete();

        return back();
    }

    public function massDestroy(MassDestroyAutreRequest $request)
    {
        Autre::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('autre_create') && Gate::denies('autre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Autre();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media', 'public');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
