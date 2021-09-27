@extends('layouts.app')
@push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('app.invoices')</h4>

                <table class="table table-bordered mt-4" id="invoiceTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('app.company')</th>
                            <th>@lang('app.package')</th>
                            <th>@lang('modules.payments.transactionId')</th>
                            <th>@lang('app.amount')</th>
                            <th>@lang('app.date')</th>
                            <th>@lang('modules.payments.nextPaymentDate')</th>
                            <th>@lang('modules.payments.paymentGateway')</th>
                            <th>@lang('app.action')</th>
                        </tr>

                    </thead>
                </table>
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



        $(function() {
            var table = $('#invoiceTable').dataTable({
                responsive: true,
                // processing: true,
                serverSide: true,
                ajax: '{!! route('superadmin.invoices.data') !!}',
                language: languageOptions(),
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'company', name: 'company'},
                    { data: 'package', name: 'package' },
                    { data: 'transaction_id', name: 'transaction_id'},
                    { data: 'amount', name: 'amount' },
                    { data: 'paid_on', name: 'paid_on' },
                    { data: 'next_pay_date', name: 'next_pay_date' },
                    { data: 'method', name: 'method' },
                    { data: 'action', name: 'action' }
                ]
            });
//            new $.fn.dataTable.FixedHeader( table );

        });
    </script>

@endpush