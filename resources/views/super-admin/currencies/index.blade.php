@extends('layouts.app')

@section('create-button')
<a href="{{ route('superadmin.currency-settings.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('app.currency')</h4>

                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th style="width: 20px">#</th>
                            <th>@lang('modules.currency.currencyName')</th>
                            <th>@lang('modules.currency.currencySymbol')</th>
                            <th>@lang('modules.currency.currencyCode')</th>
                            <th style="width: 150px">@lang('app.action')</th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($currencies as $key=>$item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{ $key+1 }}.</td>
                            <td>
                                {{ $item->currency_name }}
                            </td>
                            <td>{{ ucfirst($item->currency_symbol) }}</td>
                            <td>{{ ucfirst($item->currency_code) }}</td>
                           <td>
                                <a href="{{ route('superadmin.currency-settings.edit', $item->id) }}"
                                    class="btn btn-primary btn-circle" data-toggle="tooltip"
                                    data-original-title="@lang('app.edit')"><i class="fa fa-pencil"
                                        aria-hidden="true"></i></a>

                                @if(!$item->is_trial)
                                    <a href="javascript:;" class="btn btn-danger btn-circle sa-params" data-toggle="tooltip"
                                    data-row-id="{{ $item->id }}" data-original-title="@lang('app.delete')"><i
                                        class="fa fa-times" aria-hidden="true"></i></a>
                                @endif
                            </td>
                        </tr>
                        @empty

                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
    <script>
       $('body').on('click', '.sa-params', function(){
            var id = $(this).data('row-id');
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('superadmin.currency-settings.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                $('#row-'+id).remove();
                            }
                        }
                    });
                }
            });
        });
    </script>

@endpush