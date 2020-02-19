@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rapprochementBancaire.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rapprochement-bancaires.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.statut') }}
                        </th>
                        <td>
                            @foreach($rapprochementBancaire->statut as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.note') }}
                        </th>
                        <td>
                            {!! $rapprochementBancaire->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.du') }}
                        </th>
                        <td>
                            {{ $rapprochementBancaire->du }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.au') }}
                        </th>
                        <td>
                            {{ $rapprochementBancaire->au }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.created_at') }}
                        </th>
                        <td>
                            {{ $rapprochementBancaire->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rapprochement-bancaires.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection