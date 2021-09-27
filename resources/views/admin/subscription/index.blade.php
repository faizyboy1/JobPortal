@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush


@section('content')
<div class="row">

    @if (session('success'))
        <div class="alert alert-success col-12">{{ session('success') }}</div>
        <?php Session::forget('success');?>
    @endif
    @if (session('error'))
        <div class="alert alert-danger col-12">{{ session('error') }}</div>
        <?php Session::forget('error');?>
    @endif

    @if(!$user->is_superadmin && !is_null($activePackage) && $activePackage->package->is_trial)
        <div class="alert alert-warning col-12">
                @lang('messages.activeTrialPackage')
                @php
                $date = \Carbon\Carbon::parse($activePackage->end_date);
                $now = \Carbon\Carbon::today();

                echo $diff = $date->diffInDays($now);
                @endphp
                @lang('modules.dashboard.daysLeft')
        </div>
    @endif

    @if(!$user->is_superadmin && !is_null($activePackage) && !$activePackage->package->is_trial)
        <div class="alert alert-warning col-12">
        <h4> @lang('modules.company.currentPackage'):

        {{ $activePackage->package->name }}
        @if($activePackage->package_type == 'annual')
        - @lang('app.annual')
        @else
        - @lang('app.monthly')
        @endif
        </h4>

        <br>
        <p>
        @php

        $date = \Carbon\Carbon::parse($activePackage->end_date);
        $now = \Carbon\Carbon::today();

        echo $diff = $date->diffInDays($now);
        @endphp
        @lang('modules.dashboard.daysLeft')
        </p>
        </div>
    @endif

    <div class="col-12" style="padding-bottom: 30px">
        <div class="row">
            <div class="col-md-7">
                @lang('app.monthlyPackages')  <input id="package-switch" @if($global->package_type == 'annual') checked @endif type="checkbox" class="js-switch" />  @lang('app.yearlyPackages')
            </div>
            <div class="col-md-2">
                @if(!is_null($firstInvoice) && $paymentSetting->api_key != null && $paymentSetting->api_secret != null && $firstInvoice->method == 'Stripe')
                    @if(!is_null($subscription) && $subscription->ends_at == null)
                        <button type="button" class="btn btn-outline-danger btn-sm unsubscribe" data-method="Stripe" title="unsubscribe Plan"><i class="fa fa-ban display-small"></i> <span class="display-big">@lang('modules.subscription.unsubscribe')</span></button>
                    @endif
                @elseif(!is_null($firstInvoice) && $paymentSetting->paypal_client_id != null && $paymentSetting->paypal_secret != null && $firstInvoice->method == 'Paypal')
                    @if(!is_null($paypalInvoice) && $paypalInvoice->end_on == null  && $paypalInvoice->status == 'paid')
                        <button type="button" class="btn btn-outline-danger btn-sm unsubscribe" data-method="Paypal" title="unsubscribe Plan"><i class="fa fa-ban display-small"></i> <span class="display-big">@lang('modules.subscription.unsubscribe')</span></button>
                    @endif
                @elseif(!is_null($firstInvoice) && $paymentSetting->razorpay_key != null && $paymentSetting->razorpay_secret != null && $firstInvoice->method == 'Razorpay')
                    @if(!is_null($razorPaySubscription) && $razorPaySubscription->ends_at == null)
                        <button type="button" class="btn btn-danger waves-effect waves-light btn-sm unsubscribe" data-method="Razorpay" title="Unsubscribe Plan"><i class="fa fa-ban display-small"></i> <span class="display-big">@lang('modules.subscription.unsubscribe')</span></button>
                    @endif
                @else
                @endif
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.subscribe.invoice') }}">
                    <button type="button" class="btn btn-outline-primary btn-sm pull-right "><i class="ti-receipt"></i> @lang('menu.subscriptionDetails')</button>
                </a>
            </div>
        </div>

    </div>

    <div class="col-12">
        <div class="card-deck mb-3 text-center">
            @foreach ($packages as $item)
                <div class="card mb-4 box-shadow monthly-packages" @if($global->package_type == 'annual')  style="display:none"  @endif
                     @if($global->package_id == $item->id && $global->package_type == 'monthly')
                     style=" background-color:#a6ebff5e !important; " @endif>
                    <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{ $item->name }} </h4>
                    </div>
                    <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{ $superSettings->currency->currency_symbol.ucfirst($item->monthly_price) }} <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                            <li class="mt-2">
                                    @if ($item->career_website)
                                        <i class="fa fa-check text-success"></i>
                                        @lang('modules.saasFront.careerWebsite')
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                        <span class="text-muted">@lang('modules.saasFront.careerWebsite')</span>
                                    @endif
                            </li>
                            <li class="mt-2">
                                    @if ($item->multiple_roles)
                                        <i class="fa fa-check text-success"></i>
                                        @lang('modules.saasFront.multipleRoles')
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                        <span class="text-muted">@lang('modules.saasFront.multipleRoles')</span>
                                    @endif
                            </li>

                            <li class="mt-2">
                                    {!! ($item->no_of_job_openings > 0) ? $item->no_of_job_openings : "Unlimited" !!} @lang('modules.saasFront.activeJobs')
                            </li>
                            <li class="mt-2">
                                    {!! ($item->no_of_candidate_access > 0) ? $item->no_of_candidate_access : "Unlimited" !!} @lang('modules.saasFront.candidateAccess')
                            </li>

                        </ul>

                        @if(!($item->id == $global->package_id && $global->package_type == 'monthly') && (($paymentSetting->paypal_client_id != null && $paymentSetting->paypal_secret != null && $paymentSetting->paypal_status == 'active') ||
                        ($paymentSetting->api_key != null && $paymentSetting->api_secret != null && $paymentSetting->stripe_status == 'active') || ($paymentSetting->razorpay_key != null && $paymentSetting->razorpay_secret != null && $paymentSetting->razorpay_status == 'active')))
                            <button type="button" data-row-id="{{ $item->id }}" data-row-type="monthly" class="btn btn-md btn-block btn-success selectPackage">@lang('modules.subscription.subscribe')</button>
                        @endif
                    </div>
                </div>

            @endforeach

            @foreach ($packages as $item)
                <div class="card mb-4 box-shadow annual-packages"  @if($global->package_type == 'monthly'   || is_null($global->package_type))  style="display:none"  @endif
                     @if($global->package_id == $item->id && $global->package_type == 'annual')
                     style=" background-color:#a6ebff5e !important; " @endif>
                        <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{ $item->name }} </h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">{{ $superSettings->currency->currency_symbol.ucfirst($item->annual_price) }} <small class="text-muted">/ yr</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li class="mt-2">
                                        @if ($item->career_website)
                                            <i class="fa fa-check text-success"></i>
                                            @lang('modules.saasFront.careerWebsite')
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                            <span class="text-muted">@lang('modules.saasFront.careerWebsite')</span>
                                        @endif
                                </li>
                                <li class="mt-2">
                                        @if ($item->multiple_roles)
                                            <i class="fa fa-check text-success"></i>
                                            @lang('modules.saasFront.multipleRoles')
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                            <span class="text-muted">@lang('modules.saasFront.multipleRoles')</span>
                                        @endif
                                </li>

                                <li class="mt-2">
                                        {!! ($item->no_of_job_openings > 0) ? $item->no_of_job_openings : "Unlimited" !!} @lang('modules.saasFront.activeJobs')
                                </li>
                                <li class="mt-2">
                                        {!! ($item->no_of_candidate_access > 0) ? $item->no_of_candidate_access : "Unlimited" !!} @lang('modules.saasFront.candidateAccess')
                                </li>

                            </ul>

                            @if(!($item->id == $global->package_id && $global->package_type == 'annual') && (($paymentSetting->paypal_client_id != null && $paymentSetting->paypal_secret != null && $paymentSetting->paypal_status == 'active') ||
                        ($paymentSetting->api_key != null && $paymentSetting->api_secret != null && $paymentSetting->stripe_status == 'active')  || ($paymentSetting->razorpay_key != null && $paymentSetting->razorpay_secret != null && $paymentSetting->razorpay_status == 'active')))
                                <button type="button" data-row-id="{{ $item->id }}" data-row-type="annual" class="btn btn-md btn-block btn-success selectPackage">@lang('modules.subscription.subscribe')</button>
                            @endif
                        </div>
                </div>

            @endforeach
        </div>
    </div>
</div>

{{--Ajax Modal--}}
<div class="modal fade bs-modal-lg in" style="z-index:9999" id="package-select-form" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="button" class="btn blue">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
    var switchery = new Switchery(html, { size: 'medium' });
    });

    $('#package-switch').change(function () {
        let checked = $(this).is(":checked");
        if(checked) {
            $('.monthly-packages').hide();
            $('.annual-packages').fadeIn('slow');
        }
        else {
            $('.annual-packages').hide();
            $('.monthly-packages').fadeIn('slow');
        }
    })

    // redirect on paypal payment page
    $('body').on('click', '.paypalPayment', function(){
        var url = "{{ route('admin.paypal',[':id',':type']) }}";
        var id = $(this).data('row-id');
        var type = $(this).data('row-type');
        url = url.replace(':id', id);
        url = url.replace(':type', type);
        $.easyBlockUI('#package-select-form', 'Redirecting Please Wait...');
        window.location.href = url;
    });

    $('body').on('click', '.unsubscribe', function(){
        var type = $(this).data('method');
        swal({
            title: "@lang('errors.areYouSure')",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "@lang('app.yes')",
            cancelButtonText: "@lang('app.cancel')",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {
                var url = "{{ route('admin.subscribe.cancel-subscription',':type') }}";
                url = url.replace(':type', type);
                $.easyAjax({
                    type: 'GET',
                    url: url,
                    redirect: true,
                    success: function (response) {
                        console.log(response);
                        if (response.status == "success") {
                            $.unblockUI();
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });

    // Show Create Holiday Modal
    $('body').on('click', '.selectPackage', function(){
        var id = $(this).data('row-id');
        var type = $(this).data('row-type');
        var url = "{{ route('admin.subscribe.select-package',':id') }}?type="+type;
        url = url.replace(':id', id);
        $.ajaxModal('#package-select-form', url);
    });
</script>
@endpush