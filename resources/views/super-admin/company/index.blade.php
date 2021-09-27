@extends('layouts.app')

@push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@section('create-button')
<a href="{{ route('superadmin.company.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="icon-badge"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.totalCompanies')</span>
                <span class="info-box-number">{{ number_format($totalCompanies) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="icon-badge"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.activeCompanies')</span>
                <span class="info-box-number">{{ number_format($activeCompanies) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="icon-badge"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.inactiveCompanies')</span>
                <span class="info-box-number">{{ number_format($inactiveCompanies) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('modules.accountSettings.companyLogo')</th>
                                <th>@lang('menu.companies')</th>
                                @if(module_enabled('Subdomain'))
                                    <th>Domain</th>
                                @else
                                    <th>@lang('modules.accountSettings.companyEmail')</th>
                                @endif

                                <th>@lang('menu.packages')</th>
                                <th>@lang('app.status')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer-script')
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>
    var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: '{!! route('superadmin.company.data') !!}',
            language: languageOptions(),
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_Row_Index'},
                { data: 'logo', name: 'logo' },
                { data: 'company_name', name: 'company_name' },
                    @if(module_enabled('Subdomain'))
                { data: 'sub_domain', name: 'sub_domain' },
                    @else
                { data: 'company_email', name: 'company_email' },
                    @endif
                { data: 'package_id', name: 'package_id' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', width: '20%' }
            ]
        });


        new $.fn.dataTable.FixedHeader( table );

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

                    var url = "{{ route('superadmin.company.destroy',':id') }}";
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
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });

    @if(module_enabled('Subdomain'))
    $('body').on('click', '.domain-params', function(){
        var company_id = $(this).data('company-id');
        var company_url = $(this).data('company-url');
        swal({
            title: "Are you sure?",
            text: `You want to notify company admins about company Login URL <br> Company URL: <a href="${company_url}"><b>${company_url}</b></a>`,
            html:true,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Notify it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: "{{route('notify.domain')}}",
                    data: {'_token': token, 'company_id': company_id},
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
                            table._fnDraw();
                        }
                    }
                });
            }
        });
    });
    @endif

</script>

@endpush
