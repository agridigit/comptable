@extends('layouts.admin')
@section('content')
@can('registre_de_commerce_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.registre-de-commerces.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.registreDeCommerce.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'RegistreDeCommerce', 'route' => 'admin.registre-de-commerces.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.registreDeCommerce.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-RegistreDeCommerce">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.registreDeCommerce.fields.statut') }}
                        </th>
                        <th>
                            {{ trans('cruds.registreDeCommerce.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registreDeCommerces as $key => $registreDeCommerce)
                        <tr data-entry-id="{{ $registreDeCommerce->id }}">
                            <td>

                            </td>
                            <td>
                                @foreach($registreDeCommerce->statut as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $registreDeCommerce->created_at ?? '' }}
                            </td>
                            <td>
                                @can('registre_de_commerce_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.registre-de-commerces.show', $registreDeCommerce->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('registre_de_commerce_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.registre-de-commerces.edit', $registreDeCommerce->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('registre_de_commerce_delete')
                                    <form action="{{ route('admin.registre-de-commerces.destroy', $registreDeCommerce->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('registre_de_commerce_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.registre-de-commerces.massDestroy') }}",
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
  $('.datatable-RegistreDeCommerce:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection