@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/select/1.3.0/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

    <style>
        .mb-20{
            margin-bottom: 20px
        }
        .datepicker{
            z-index: 9999 !important;
        }
    </style>
@endpush

@if(in_array("add_job_applications", $userPermissions))
@section('create-button')
    <a href="{{ route('admin.job-applications.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection
@endif

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row clearfix">
                        <div class="col-md-12 mb-20">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-success btn-sm toggle-filter">
                                        <i class="fa fa-sliders"></i> @lang('app.filterResults')
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <form id="send-email-form" method="POST" class="pull-right">
                                        <div class="form-group mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <select class="select2" name="mail_status" id="mail-status" data-style="form-control">
                                                        <option value="all">@lang('modules.newJobEmail.selectMailStatus')</option>
                                                        <option value="sent">@lang('modules.newJobEmail.mailSent')</option>
                                                        <option value="not_sent">@lang('modules.newJobEmail.mailNotSent')</option>
                                                    </select>        
                                                </div>
                                                <div class="col">
                                                    <select class="select2" name="job_for_email" id="job-for-email" data-style="form-control" data-placeholder="@lang('modules.newJobEmail.selectJob')">
                                                        @forelse ($jobs as $job)
                                                            <option value="{{ $job->id }}">{{ ucfirst($job->title) }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <button type="button" id="send-emails" class="btn btn-sm btn-warning"><i class="fa fa-envelope-o"></i> @lang('app.sendEmails')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row b-b b-t mb-3" style="display: none; background: #fbfbfb;" id="ticket-filters">
                        <div class="col-md-12">
                            <h4 class="mt-2">@lang('app.filterBy') <a href="javascript:;" class="pull-right mt-2 mr-2 toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                        </div>
                        <div class="col-md-12">
                            <form action="" id="filter-form" class="row" >
                                <div class="col-md-4">
                                    <div class="example">
                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" id="start-date" placeholder="Show Results From" value="" />
                                            <span class="input-group-addon bg-info b-0 text-white p-1">@lang('app.to')</span>
                                            <input type="text" class="form-control" id="end-date" placeholder="Show Results To" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="select2" name="status" id="status" data-style="form-control">
                                            <option value="all">@lang('modules.jobApplication.allStatus')</option>
                                            @forelse($boardColumns as $status)
                                                <option value="{{$status->id}}">{{ucfirst($status->status)}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="select2" name="jobs" id="jobs" data-style="form-control">
                                            <option value="all">@lang('modules.jobApplication.allJobs')</option>
                                            @forelse($jobs as $job)
                                                <option title="{{ucfirst($job->title)}}" value="{{$job->id}}">{{ucfirst($job->title)}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="select2" name="location" id="location" data-style="form-control">
                                            <option value="all">@lang('modules.jobApplication.allLocation')</option>
                                            @forelse($locations as $location)
                                                <option value="{{$location->id}}">{{ucfirst($location->location)}}</option>
                                            @empty
                                            @endforelse

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-1 d-flex justify-content-center align-items-center">
                                                <label for="skill">@lang('menu.skills'):</label>
                                            </div>
                                            <div class="col-sm-11">
                                                <select class="select2 select2-multiple" name="skill[]" multiple="multiple" id="skill" data-style="form-control" data-placeholder="Select Skills">
                                                    @forelse($skills as $skill)
                                                        <option value="{{$skill->id}}">{{ucfirst($skill->name)}}</option>
                                                    @empty
                                                    @endforelse

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="button" id="apply-filters" class="btn btn-sm btn-success"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                        <button type="button" id="reset-filters" class="btn btn-sm btn-dark "><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive m-t-40">
                        <div class="row text-center mb-2">
                            <div class="col-sm-12 selected-message">
                                    All <strong>10</strong> applicants on this page are selected. 
                                    <a href="javascript:selectAllApplicants();">Select all 100 applicants</a>
                            </div>
                        </div>
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <div class="checkbox form-check">
                                        <input type="checkbox" name="select_all_applicants" id="select-all">
                                        <label for="select-all"></label>
                                    </div>
                                </th>
                                <th>#</th>
                                <th>@lang('modules.jobApplication.applicantName')</th>
                                <th>@lang('menu.jobs')</th>
                                <th>@lang('menu.locations')</th>
                                <th>@lang('app.status')</th>
                                <th>@lang('modules.newJobEmail.mailStatus')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="mail-confirm-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        @lang('errors.areYouSure')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body d-flex flex-column align-items-center">
                    <div class="text text-center mb-4" style="font-size: 16px"></div>
                    <div>
                        <button type="button" class="btn dark btn-outline mr-2" data-dismiss="modal">@lang('app.cancel')</button>
                        <button type="button" class="btn btn-success" id="send-emails-confirm">@lang('app.sendEmails')</button>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                </div> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/select/1.3.0/js/select.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

    <script>
        $('#start-date').datepicker({
            format: 'yyyy-mm-dd'
        })
        $('#end-date').datepicker({
            format: 'yyyy-mm-dd'
        })
        
        var table;
        let tableData;
        var selected = [];
        var allSelected = false;
        
        tableLoad('load');
        $('.selected-message').css('opacity', 0);
        // For select 2
        $(".select2").select2({
            width: '100%'
        });

        function resetSelect() {
            selected = [];
            $('#select-all').prop('checked', false);
        }

        function setText() {
            const applicantsOnPage = tableData.page.info().end-tableData.page.info().start;
            const totalApplicants = tableData.page.info().recordsTotal;

            let text = '@lang('modules.newJobEmail.applicantsSelected', ['applicantsOnPage' => ':applicantsOnPage']) <a href="javascript:selectAllApplicants();">@lang('modules.newJobEmail.selectAllApplicants', ['totalApplicants' => ':totalApplicants'])</a>';

            text = text.replace(':applicantsOnPage', applicantsOnPage);
            text = text.replace(':totalApplicants', totalApplicants);

            $('.selected-message').html(text);
        }

        function toggleText(status) {
            if (status == 'show') {
                setText();
                $('.selected-message').css({'opacity': 1, 'transition': 'all 0.3s'});
            }
            else {
                $('.selected-message').css({'opacity': 0, 'transition': 'all 0.3s'});
            }
        }

        function selectAllApplicants() {
            selected = [];
            allSelected = true;
            const totalApplicants = tableData.page.info().recordsTotal;

            let text = '@lang('modules.newJobEmail.allApplicantsSelected', ['totalApplicants' => ':totalApplicants']) <a href="javascript:clearSelection();">@lang('modules.newJobEmail.clearSelection')</a>';

            text = text.replace(':totalApplicants', totalApplicants);

            $('.selected-message').html(text);
        }

        function clearSelection() {
            tableLoad('filter');
        }
        
        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#filter-form').find('select').val('all').trigger('change');
            tableLoad('load');
            resetSelect();
        })

        $('#apply-filters').click(function () {
            tableLoad('filter');
            resetSelect();
        });

        function tableLoad(type) {

            var status = $('#status').val();
            var jobs = $('#jobs').val();
            var location = $('#location').val();
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();
            var skill = $('#skill').val();
            var jobId = $('#job-for-email').val();
            var mailStatus = $('#mail-status').val();

            table = $('#myTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                order: [[1, 'asc']],
                "rowCallback": function( row, data ) {
                    var input = $(row).find('input');

                    var id = data.id;
                    var index = $.inArray(id, selected);
            
                    if ( index !== -1 ) {
                        input.prop('checked', true);
                    }                    
                },
                ajax: '{!! route('admin.jobs.applicationData') !!}?status='+status+'&location='+location+'&startDate='+startDate+'&endDate='+endDate+'&jobs='+jobs+'&skill='+skill+'&jobId='+jobId+'&mailStatus='+mailStatus,
                language: languageOptions(),
                "fnDrawCallback": function (oSettings) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });

                    var totalInputs = tableData.page.info().end - tableData.page.info().start;

                    if (totalInputs > 0) {
                        $('input#select-all').prop('disabled', false);
                        if ($('input.form-check-input:checked').length == totalInputs) {
                            $('input#select-all').prop('checked', true);
                        }
                        else {
                            $('input#select-all').prop('checked', false);
                        }
                    }
                    else {
                        $('input#select-all').prop('disabled', true);
                    }

                    if (allSelected) {
                        selected = [];
                        allSelected = false;
                    }

                    toggleText('hide');
                },
                columns: [
                    {data: 'checkbox', name:'checkbox', orderable: false, searchable: false},
                    {data: 'id', name:'id'},
                    {data: 'full_name', name: 'full_name', width: '17%'},
                    {data: 'title', name: 'jobs.title', width: '30%'},
                    {data: 'location', name: 'job_locations.location'},
                    {data: 'status', name: 'application_status.status'},
                    {data: 'mail_status', name: 'mail_status', orderable: false, searchable: false},
                ]
            });

            tableData = $('#myTable').DataTable();

            new $.fn.dataTable.FixedHeader(table);
        }

        table.on( 'search.dt', function () {
            selected = [];
        } );

        $('#myTable tbody').on('change', 'input', function () {
            var id = this.id;
            
            var index = $.inArray(id, selected);

            if (!$(this).is(':checked')) {
                if (!allSelected) {
                    selected.splice( index, 1 );
                }
                else {
                    $('#myTable tbody input:checked').each(function () {
                        selected.push(this.id);
                        allSelected = false;
                    })
                }
                $(this).prop('checked', false);
                toggleText('hide');
            }
            else {
                if ( index === -1 ) {
                    selected.push( id );
                    $(this).prop('checked', true);
                }                    
            }

            if ($('#myTable tbody input:checked').length == tableData.page.info().end - tableData.page.info().start) {
                $('input#select-all').prop('checked', true);
                toggleText('show');
            }
            else {
                $('input#select-all').prop('checked', false);
            }
        } );

        $('#myTable input#select-all').change(function () {
            if ($(this).is(':checked')) {
                $('#myTable tbody input').each(function () {
                    var checkbox = $(this);
                    var id = checkbox.prop('id');
                    var index = $.inArray(id, selected);

                    if (index === -1) {
                        selected.push( id );
                    }
                    checkbox.prop('checked', true);
                })
                $(this).prop('checked', true);
                toggleText('show'); 
            }
            else {
                $('#myTable tbody input').each(function () {
                    var checkbox = $(this);
                    var id = this.id;

                    // remove from selected
                    var index = $.inArray(id, selected);

                    if (index !== -1) {
                        selected.splice( index, 1 );
                    }
                    checkbox.prop('checked', false);
                })
                toggleText('hide');
                allSelected = false;
            }
        })

        table.on('click', '.show-detail', function () {
            $(".right-sidebar").slideDown(50).addClass("shw-rside");

            var id = $(this).data('row-id');
            var url = "{{ route('admin.job-applications.show',':id') }}";
            url = url.replace(':id', id);

            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    if (response.status == "success") {
                        $('#right-sidebar-content').html(response.view);
                    }
                }
            });
        });

        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        });

        $('#send-emails-confirm').click(function () {
            let filterData = {
                job_for_email: $('#job-for-email').val(),
                _token: '{{ csrf_token() }}',
                selectedIds: selected,
                allSelected: allSelected,
                excludeSent: $('#exclude-sent').is(':checked')
            }
            
            $.easyAjax({
                url: '{{ route('admin.jobs.sendEmails') }}',
                type: 'POST',
                data: filterData,
                container: '#mail-confirm-modal',
                success: function (response) {
                    if (response.status == 'success') {
                        $('#mail-confirm-modal').modal('hide');
                        $('input.form-check-input:checked').each(function () {
                            $(this).prop('checked', false);
                        });
                        tableLoad('filter');
                    }
                }
            })
        })

        $('#send-emails').click(function (e) {
            e.preventDefault();

            if (allSelected || selected.length > 0) {
                let text = "<div class='text-info mb-3'>@lang('errors.sendEmailText', ['selectedApplicantsCount', ':selectedApplicantsCount'])</div>";
                text = text.replace(':selectedApplicantsCount', allSelected ? tableData.page.info().recordsTotal : selected.length);
    
                text += `<div class="form-check">
                    <input class="form-check-input" type="checkbox" id="exclude-sent">
                    <label class="form-check-label" for="exclude-sent">
                        @lang('errors.excludeSent')
                    </label>
                </div>`

                $('#mail-confirm-modal').find('.modal-body .text').html(text);
                $('#mail-confirm-modal').modal('show');
            }
            else {
                $.showToastr('@lang('messages.selectApplicantsForEmail')', 'error');
            }
        })

        $('#job-for-email').change(function () {
            tableLoad('filter');
        })

        $('#mail-status').change(function () {
            tableLoad('filter');
        })
    </script>
@endpush