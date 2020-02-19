@extends('layouts.admin')
@section('content')
@can('rapprochement_bancaire_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.rapprochement-bancaires.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.rapprochementBancaire.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'RapprochementBancaire', 'route' => 'admin.rapprochement-bancaires.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rapprochementBancaire.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-RapprochementBancaire">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.statut') }}
                        </th>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.du') }}
                        </th>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.au') }}
                        </th>
                        <th>
                            {{ trans('cruds.rapprochementBancaire.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapprochementBancaires as $key => $rapprochementBancaire)
                        <tr data-entry-id="{{ $rapprochementBancaire->id }}">
                            <td>

                            </td>
                            <td>
                                @foreach($rapprochementBancaire->statut as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $rapprochementBancaire->du ?? '' }}
                            </td>
                            <td>
                                {{ $rapprochementBancaire->au ?? '' }}
                            </td>
                            <td>
                                {{ $rapprochementBancaire->created_at ?? '' }}
                            </td>
                            <td>
                                @can('rapprochement_bancaire_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.rapprochement-bancaires.show', $rapprochementBancaire->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('rapprochement_bancaire_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.rapprochement-bancaires.edit', $rapprochementBancaire->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('rapprochement_bancaire_delete')
                                    <form action="{{ route('admin.rapprochement-bancaires.destroy', $rapprochementBancaire->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('rapprochement_bancaire_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.rapprochement-bancaires.massDestroy') }}",
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
    order: [[ 4, 'desc' ]],
    pageLength: 25,
  });
  $('.datatable-RapprochementBancaire:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection