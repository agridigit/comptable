@extends('layouts.admin')
@section('content')
@can('liste_des_moyen_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.liste-des-moyens.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.listeDesMoyen.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'ListeDesMoyen', 'route' => 'admin.liste-des-moyens.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.listeDesMoyen.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ListeDesMoyen">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.listeDesMoyen.fields.liste_des_moyens') }}
                        </th>
                        <th>
                            {{ trans('cruds.listeDesMoyen.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listeDesMoyens as $key => $listeDesMoyen)
                        <tr data-entry-id="{{ $listeDesMoyen->id }}">
                            <td>

                            </td>
                            <td>
                                @foreach($listeDesMoyen->liste_des_moyens as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $listeDesMoyen->created_at ?? '' }}
                            </td>
                            <td>
                                @can('liste_des_moyen_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.liste-des-moyens.show', $listeDesMoyen->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('liste_des_moyen_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.liste-des-moyens.edit', $listeDesMoyen->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('liste_des_moyen_delete')
                                    <form action="{{ route('admin.liste-des-moyens.destroy', $listeDesMoyen->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('liste_des_moyen_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.liste-des-moyens.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 2, 'desc' ]],
    pageLength: 25,
  });
  $('.datatable-ListeDesMoyen:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection