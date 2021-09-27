@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <form action="" class="ajax-form" id="createForm" method="POST">
                        @csrf
                        <h4 class="box-title">@lang('modules.footerSettings.footerSettings')</h4>
                        <hr>
                        {{-- <div class="form-group">
                            <select name="language" class="form-control selectpicker" id="language_switcher" onchange="changeForm();">
                                @forelse ($activeLanguages as $language)
                                <option
                                        value="{{ $language->id }}" data-content=' <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_code) }}'>{{ ucfirst($language->language_code) }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div> --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @forelse ($activeLanguages as $language)
                                <li class="nav-item">
                                    <a 
                                        class="nav-link @if($language->language_code == 'en') active @endif"
                                        id="{{$language->language_code}}-tab"
                                        data-toggle="tab"
                                        data-language-id="{{$language->id}}"
                                        href="#{{$language->language_code}}"
                                        role="tab"
                                        aria-controls="{{$language->language_code}}"
                                        aria-selected="true"
                                    >
                                        <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_name) }}
                                    </a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                        <div id="copyright-section">
                            @include('super-admin.footer-settings.copyright-input', $footerSettings)
                        </div>
                        <div class="form-group">
                            <h5 class="box-title">@lang('modules.footerSettings.socialLinks')</h5>
                            <span class="text-danger">@lang('modules.footerSettings.socialLinksNote')</span><br><br>
                            <div class="row">
                                @forelse($footerSettings->social_links as $link)
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="{{ $link['name'] }}">
                                                @lang('modules.footerSettings.'.$link['name'])
                                            </label>
                                            <input
                                                class="form-control"
                                                id="{{ $link['name'] }}"
                                                name="social_links[{{ $link['name'] }}]"
                                                type="url"
                                                value="{{ $link['link'] }}"
                                                placeholder="@lang('modules.footerSettings.enter'.ucfirst($link['name']).'Link')">
                                        </div>
                                    </div>
                                @empty
                                
                                @endforelse
                            </div>
                        </div>
                        <button class="btn btn-success" id="save-form" type="button"><i class="fa fa-check"></i> @lang('app.save')</button>
                    </form>
                    <hr>
                    <div id="footer-menu-setting">
                        <h4 class="box-title">@lang('modules.footerSettings.footerMenuSetting')</h4>
                        <button class="btn btn-sm btn-primary" onclick="javascript:createNewFooterMenuSetting();">@lang('app.createNew')</button>
                        <div class="table-responsive mt-3">
                            <table id="myTable" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('app.name')</th>
                                        <th>@lang('app.description')</th>
                                        <th>@lang('app.language')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
        function createNewFooterMenuSetting() {
            let url = "{{ route('superadmin.footer-settings.create') }}"

            $.ajaxModal('#application-lg-modal', url);
        }

        function updateNewFooterMenuSetting(id) {
            let url = "{{ route('superadmin.footer-settings.edit', ':id') }}";
            url = url.replace(':id', id);

            $.ajaxModal('#application-lg-modal', url);
        }

        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            changeForm(e.target);
        })

        function changeForm(target) {
            $.easyAjax({
                url: "{{ route('superadmin.footer-settings.index') }}",
                container: '#copyright-section',
                data: {
                    language_settings_id: $(target).data('language-id')
                },
                type: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#copyright-section').html(response.view);
                    }
                }
            })
        }

        var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: '{!! route('superadmin.footer-settings.data') !!}',
            language: languageOptions(),
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_Row_Index'},
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'language', name: 'language' },
                { data: 'action', name: 'action', width: '20%' }
            ]
        });

        new $.fn.dataTable.FixedHeader( table );

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('superadmin.footer-settings.store')}}',
                type: "POST",
                container: '#createForm',
                data: $('#createForm').serialize()+'&language='+$('#myTab a.active').data('language-id'),
            })
        });

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

                    var url = "{{ route('superadmin.footer-settings.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                // swal("Deleted!", response.message, "success");
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush