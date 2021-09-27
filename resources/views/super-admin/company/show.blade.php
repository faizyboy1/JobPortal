@extends('layouts.app') 

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <style>
        .company-logo {
            max-height: 30px;
        }

        .company-logo-div {
            border-radius: 5px;
            padding: 15px 0 0 10px;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-8">
      
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 company-logo-div bg-dark" >
                        <p><img src="{{ $company->logo_url }}" class="img-fluid company-logo" /></p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <small class="text-muted">@lang('modules.company.registeredOn') {{ $company->created_at->format('d M, Y') }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 b-r">
                        <label>@lang('modules.accountSettings.companyName')</label>
                        @if($company->isFeatured())
                            <label class="badge bg-success">@lang('app.featured')</label>
                        @endif
                        <p>{{ $company->company_name }} </p>
                    </div>
                    <div class="col-md-6 pl-3">
                        <label>@lang('modules.accountSettings.companyEmail')</label>
                        <p>{{ $company->company_email }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 b-r">
                        <label>@lang('modules.accountSettings.companyPhone')</label>
                        <p>{{ $company->company_phone }}</p>
                    </div>
                    <div class="col-md-6 pl-3">
                        <label>@lang('modules.accountSettings.companyWebsite')</label>
                        <p>{{ $company->website }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 b-r">
                        <label>@lang('modules.accountSettings.companyAddress')</label>
                        <p>{!! $company->address !!}</p>
                    </div>
                    <div class="col-md-6 pl-3">
                        <label>@lang('app.status')</label>
                        <p>
                            @if($company->status == 'active')
                                <label class="badge bg-success">@lang('app.active')</label>
                            @else
                                <label class="badge bg-danger">@lang('app.inactive')</label>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('modules.company.currentPackage')</h4>
                    <table class="table table-condensed">
                        <tr>
                            <td><strong>@lang('app.package'):</strong></td>
                            <td>{{ $company->package->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>@lang('app.package') @lang('app.type'):</strong></td>
                            <td>{{ (!is_null($company->package_type)) ? __('app.'.$company->package_type) : "--" }}</td>
                        </tr>
                        <tr>
                            <td><strong>@lang('app.price'):</strong></td>
                            @if($company->package_type == 'monthly')
                                <td>{{ $global->currency->currency_symbol.$company->package->monthly_price }}</td>
                            @else
                                <td>{{ $global->currency->currency_symbol.$company->package->annual_price }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><strong>@lang('modules.subscription.expiresOn'):</strong></td>
                            <td
                            @if(!is_null($company->licence_expire_on) && $company->licence_expire_on->isPast() )
                                class="text-danger"
                            @else
                                class="text-info"
                            @endif
                            >
                            @if(!is_null($company->licence_expire_on))
                            {!! $company->licence_expire_on->format('d M, Y').' <br><small><i>'.$company->licence_expire_on->diffForHumans().'</i></small>' !!}
                            @endif

                            @if(!is_null($companyPackage))
                                @php
                                $date = \Carbon\Carbon::parse($companyPackage->end_date);
                                $now = \Carbon\Carbon::today();

                                echo $diff = $date->diffInDays($now);    
                                @endphp
                                @lang('modules.dashboard.daysLeft')
                            @endif

                            </td>
                        </tr>
                       
                    </table>
                    <div class="row">
                        <div class="col mb-2">
                            <a href="javascript:;" data-company-id="{{ $company->id }}" id="change-package" class="btn btn-md btn-outline-primary btn-block "><i class="fa fa-gear"></i> @lang('app.change') @lang('app.package')</a>
                        </div>
                        <div class="col">
                            <a href="javascript:;" data-company-id="{{ $company->id }}" id="login-as-company" class="btn btn-md btn-outline-success btn-block "><i class="fa fa-sign-in"></i> @lang('app.loginAsCompany')</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('menu.packages')</h4>

                <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('app.package')</th>
                                    <th>@lang('app.type')</th>
                                    <th>@lang('app.startDate')</th>
                                    <th>@lang('app.endDate')</th>
                                    <th>@lang('app.status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company->packages as $key=>$item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ ucfirst($item->package->name) }}</td>
                                        <td>{{ $item->package_type }}</td>
                                        <td>{{ $item->start_date->format('d M, Y') }}</td>
                                        <td>{{ (!is_null($item->end_date)) ? $item->end_date->format('d M, Y') : "" }}</td>
                                        <td>
                                            @if ($item->status == 'active')
                                                <label class="badge bg-success">@lang('app.active')</label>
                                            @else
                                                <label class="badge bg-danger">@lang('app.inactive')</label>              
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-script')
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>

<script>
    // For select 2
        $(".select2").select2();

        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

       

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.company.store")}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

       $('#myTable').dataTable({
            aaSorting: [[0, 'desc']],
            responsive: true,
            language: languageOptions()            
        });


        $('#change-package').click(function(){
            var id = $(this).data('company-id');
            var url = "{{ route('superadmin.company.changePackage',':id') }}";
            url = url.replace(':id', id);
            $('#modelHeading').html('@lang("app.package")');
            $('#application-lg-modal').modal('hide');
            $.ajaxModal('#application-lg-modal', url);
        });

        $('#login-as-company').click(function () {
            var id = $(this).data('company-id');
            var url = "{{ route('superadmin.company.loginAsCompany',':id') }}";
            url = url.replace(':id', id);

            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.loginInfo')",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#28A745",
                confirmButtonText: "@lang('app.login')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    $.easyAjax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                location.href = "{{ route('admin.dashboard') }}"
                            }
                        }
                    });
                }
            });
        })
    
</script>



@endpush