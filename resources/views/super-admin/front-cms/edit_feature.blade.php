@extends('layouts.app')

@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('menu.cmsFeatures')</h4>

                <form id="editSettings" class="ajax-form" >
                    @csrf
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
                        <label for="exampleInputPassword1">@lang('modules.frontCms.image')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="input-file-now" name="image" class="dropify"
                                    data-default-file="{{ $feature->image_url }}" />
                            </div>
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
<script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>


<script>
    var drEvent = $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });


        drEvent.on('dropify.afterClear', function(event, element){
//           $('#remove_header_background').val('yes'); 
        });

        $('#add-feature').click(function() {
            $('#editSettings').toggle();
        })

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.front-cms.updatefeatures", $feature->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

</script>




@endpush