@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('app.createNew')</h4>
                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('app.name')</label>
                                    <input type="text" class="form-control" name="name">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">@lang('app.email')</label>
                                    <input class="form-control" id="email" name="email" >
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('app.password')</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('app.confirmPassword')</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">@lang('app.active')</option>
                                        <option value="inactive">@lang('app.inactive')</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <button type="button" id="save-form" class="btn btn-success"><i
                                    class="fa fa-check"></i> @lang('app.save')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>

    <script>

        // For select 2
        $(".select2").select2();

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('superadmin.superadmins.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize()
            })
        });


    </script>
@endpush