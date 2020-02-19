@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.etatDesHoraire.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.etat-des-horaires.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.etatDesHoraire.fields.etat_des_horaires') }}
                        </th>
                        <td>
                            @foreach($etatDesHoraire->etat_des_horaires as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.etatDesHoraire.fields.note') }}
                        </th>
                        <td>
                            {!! $etatDesHoraire->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.etatDesHoraire.fields.created_at') }}
                        </th>
                        <td>
                            {{ $etatDesHoraire->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.etat-des-horaires.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection