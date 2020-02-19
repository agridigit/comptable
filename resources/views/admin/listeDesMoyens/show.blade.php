@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.listeDesMoyen.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.liste-des-moyens.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.listeDesMoyen.fields.liste_des_moyens') }}
                        </th>
                        <td>
                            @foreach($listeDesMoyen->liste_des_moyens as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.listeDesMoyen.fields.note') }}
                        </th>
                        <td>
                            {!! $listeDesMoyen->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.listeDesMoyen.fields.created_at') }}
                        </th>
                        <td>
                            {{ $listeDesMoyen->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.liste-des-moyens.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection