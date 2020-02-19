@extends('layouts.admin')
@section('content')
@can('identifiant_fiscal_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.identifiant-fiscals.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.identifiantFiscal.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'IdentifiantFiscal', 'route' => 'admin.identifiant-fiscals.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.identifiantFiscal.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-IdentifiantFiscal">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.identifiantFiscal.fields.statut') }}
                        </th>
                        <th>
                            {{ trans('cruds.identifiantFiscal.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($identifiantFiscals as $key => $identifiantFiscal)
                        <tr data-entry-id="{{ $identifiantFiscal->id }}">
                            <td>

                            </td>
                            <td>
                                @foreach($identifiantFiscal->statut as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $identifiantFiscal->created_at ?? '' }}
                            </td>
                            <td>
                                @can('identifiant_fiscal_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.identifiant-fiscals.show', $identifiantFiscal->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('identifiant_fiscal_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.identifiant-fiscals.edit', $identifiantFiscal->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('identifiant_fiscal_delete')
                                    <form action="{{ route('admin.identifiant-fiscals.destroy', $identifiantFiscal->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('identifiant_fiscal_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.identifiant-fiscals.massDestroy') }}",
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
  $('.datatable-IdentifiantFiscal:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection