@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.registreDeCommerce.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.registre-de-commerces.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.registreDeCommerce.fields.statut') }}
                        </th>
                        <td>
                            @foreach($registreDeCommerce->statut as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.registreDeCommerce.fields.note') }}
                        </th>
                        <td>
                            {!! $registreDeCommerce->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.registreDeCommerce.fields.created_at') }}
                        </th>
                        <td>
                            {{ $registreDeCommerce->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.registre-de-commerces.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection