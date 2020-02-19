@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pvPouvoir.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pv-pouvoirs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pvPouvoir.fields.statut') }}
                        </th>
                        <td>
                            @foreach($pvPouvoir->statut as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pvPouvoir.fields.note') }}
                        </th>
                        <td>
                            {!! $pvPouvoir->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pvPouvoir.fields.created_at') }}
                        </th>
                        <td>
                            {{ $pvPouvoir->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pv-pouvoirs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection