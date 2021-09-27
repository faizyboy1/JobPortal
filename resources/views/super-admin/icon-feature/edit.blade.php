@extends('layouts.app')

@push('head-script')
    <link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iconpicker/css/fontawesome-iconpicker.css') }}">
@endpush


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('menu.iconFeatures')</h4>

                <form id="editSettings" class="ajax-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <select name="language" class="form-control selectpicker" id="language_switcher">
                            @forelse ($activeLanguages as $language)
                            <option
                                @if($language->id === $feature->language_settings_id) selected @endif
                                value="{{ $language->id }}"
                                data-content=' <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_code) }}'
                            >
                                {{ ucfirst($language->language_code) }}
                            </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label>@lang('modules.frontCms.title')</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $feature->title }}">
                    </div>
                    <div class="form-group">
                        <label>@lang('modules.frontCms.description')</label>
                        <textarea name="description" class="form-control" id="description" cols="30"
                            rows="4">{{ $feature->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('modules.frontCms.icon')</label>
                        <div class="btn-group">
                            <button data-selected="graduation-cap" type="button"
                                    class="icp icp-dd btn btn-sm btn-outline-secondary dropdown-toggle iconpicker-component"
                                    data-toggle="dropdown">
                                <i class="fa fa-fw">
                                    <i class="{{ $feature->icon }}"></i>
                                </i>
                                <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu"></div>
                            <input class="" name="icon" id="iconInput" type="hidden" value="{{ $feature->icon }}" />
                        </div>
                    </div>

                    <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                        @lang('app.save')
                    </button>
                    <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-script')
<script src="{{ asset('assets/plugins/iconpicker/js/fontawesome-iconpicker.js') }}"></script>

<script>
    $('.icp-dd').iconpicker({
        title: 'Dropdown with picker',
        component:'.btn > i',
        templates: {
            iconpickerItem: '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>'
        }
    });

    $(function () {
        $('.icp').on('iconpickerSelected', function (e) {
           $('#iconInput').val(e.iconpickerValue);
        });
    });
    
    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route("superadmin.icon-features.update", $feature->id)}}',
            container: '#editSettings',
            type: "POST",
            redirect: true,
            file: true
        })
    });
</script>
@endpush