@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.autorisationDactivite.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.autorisation-dactivites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.autorisationDactivite.fields.statut') }}
                        </th>
                        <td>
                            @foreach($autorisationDactivite->statut as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.autorisationDactivite.fields.note') }}
                        </th>
                        <td>
                            {!! $autorisationDactivite->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.autorisationDactivite.fields.created_at') }}
                        </th>
                        <td>
                            {{ $autorisationDactivite->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.autorisation-dactivites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection