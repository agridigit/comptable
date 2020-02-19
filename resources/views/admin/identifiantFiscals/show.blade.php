@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.identifiantFiscal.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.identifiant-fiscals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.identifiantFiscal.fields.statut') }}
                        </th>
                        <td>
                            @foreach($identifiantFiscal->statut as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.identifiantFiscal.fields.note') }}
                        </th>
                        <td>
                            {!! $identifiantFiscal->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.identifiantFiscal.fields.created_at') }}
                        </th>
                        <td>
                            {{ $identifiantFiscal->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.identifiant-fiscals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection