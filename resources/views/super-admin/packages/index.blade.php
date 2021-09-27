@extends('layouts.app')

@section('create-button')
<a href="{{ route('superadmin.packages.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('menu.packages')</h4>
                <div class="col-md-12">
                    @if(!is_null($packageData) && $paymentSetting->stripe_status == 'active')

                        <div class="alert alert-danger col-md-12">
                            <div class="col-md-12"> @lang('messages.stripePlanIdRequired')</div>
                        </div>
                    @endif
                </div>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th style="width: 20px">#</th>
                            <th>@lang('modules.packages.packageName')</th>
                            <th>@lang('modules.packages.monthlyPrice')</th>
                            <th>@lang('modules.packages.annualPrice')</th>
                            <th>@lang('app.feature')</th>
                            <th>@lang('app.status')</th>
                            <th style="width: 150px">@lang('app.action')</th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($packages as $key=>$item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{ $key+1 }}.</td>
                            <td>
                                {{ $item->name }}
                                @if($item->recommended)
                                    <br><label class="badge bg-secondary"><i class="fa fa-star text-warning"></i> @lang('app.recommended')</label>
                                @endif
                            </td>
                            <td>{{ $global->currency->currency_symbol.ucfirst($item->monthly_price) }}
                                @if($paymentSetting->stripe_status == 'active')
                                    <br><small>(@lang('app.stripePlanId') : {{ $item->stripe_monthly_plan_id ?? '-' }})</small>
                                @endif

                            </td>
                            <td>{{ $global->currency->currency_symbol.ucfirst($item->annual_price) }}
                                @if($paymentSetting->stripe_status == 'active')
                                    <br><small>(@lang('app.stripePlanId') : {{ $item->stripe_annual_plan_id ?? '-' }})</small>
                                @endif
                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>
                                            @if ($item->career_website)
                                                <i class="fa fa-check text-success"></i> 
                                            @else
                                                <i class="fa fa-times text-danger"></i> 
                                            @endif
                                              @lang('modules.packages.careerWebsite')
                                        </small>
                                    </li>
                                    <li>
                                        <small>
                                            @if ($item->multiple_roles)
                                                <i class="fa fa-check text-success"></i> 
                                            @else
                                                <i class="fa fa-times text-danger"></i> 
                                            @endif
                                              @lang('modules.packages.multipleRoles')
                                        </small>
                                    </li>
                                    <li>
                                        <small>
                                            @if ($item->recommended)
                                                <i class="fa fa-check text-success"></i> 
                                            @else
                                                <i class="fa fa-times text-danger"></i> 
                                            @endif
                                              @lang('modules.packages.recommended')
                                        </small>
                                    </li>
                                    <li class="mt-2">
                                        <small>
                                        @lang('modules.packages.noOfJobOpenings'): {!! ($item->no_of_job_openings > 0) ? $item->no_of_job_openings : "--" !!}
                                        </small>
                                    </li>
                                    <li class="mt-2">
                                        <small>
                                        @lang('modules.packages.noOfCandidateAccess'): {!! ($item->no_of_candidate_access > 0) ? $item->no_of_candidate_access : "--" !!}
                                        </small>
                                    </li>
                                    
                                </ul>
                            </td>
                            <td>
                                @if($item->status)
                                    <label class="badge bg-success">@lang('app.active')</label>
                                @else
                                    <label class="badge bg-danger">@lang('app.inactive')</label>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.packages.edit', $item->id) }}"
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

                    var url = "{{ route('superadmin.packages.destroy',':id') }}";
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