<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">

<div class="modal-header">
    <h4 class="modal-title">@lang('modules.footerMenuSettings.editFooterMenu')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="createMenuForm" class="ajax-form" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <select name="language" class="form-control selectpicker" id="language_switcher">
                @forelse ($activeLanguages as $language)
                <option
                    @if($language->id === $footerMenu->language_settings_id) selected @endif
                    value="{{ $language->id }}"
                    data-content=' <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_code) }}'
                >
                    {{ ucfirst($language->language_code) }}
                </option>
                @empty
                @endforelse
            </select>
        </div>
        <h5 class="box-title">@lang('modules.footerMenuSettings.seoDetails')</h5>
        <div class="row">
            <div class="col-md-12">
                <!-- text input -->
                <div class="form-group">
                    <label for="seo_title">@lang('modules.footerMenuSettings.seoTitle')</label>
                    <input type="text" name="seo_title" id="seo_title" class="form-control form-control-lg" value="{{ $footerMenu->seo_details->first()->seo_title }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="seo_author">@lang('modules.footerMenuSettings.seoAuthor')</label>
                    <input type="text" name="seo_author" id="seo_author" class="form-control form-control-lg" value="{{ $footerMenu->seo_details->first()->seo_author }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="seo_description">@lang('modules.footerMenuSettings.seoDescription')</label>
                    <textarea name="seo_description" id="seo_description" rows="3" class="form-control form-control-lg">{{ $footerMenu->seo_details->first()->seo_description }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="seo_keywords">@lang('modules.footerMenuSettings.seoKeywords')</label>
                    <textarea name="seo_keywords" id="seo_keywords" rows="3" class="form-control form-control-lg">{{ $footerMenu->seo_details->first()->seo_keywords }}</textarea>
                </div>
            </div>
        </div>
        <hr>
        <h5 class="box-title">@lang('modules.footerMenuSettings.footerMenuDetails')</h5>
        <div class="row">
            <div class="col-md-12">
                <!-- text input -->
                <div class="form-group">
                    <label for="title">@lang('app.title')</label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg" value="{{ $footerMenu->name }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <textarea name="description" id="description" rows="3" class="summernote form-control form-control-lg">{{ $footerMenu->description }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" id="save-menu-form" class="btn btn-success btn-light-round"><i
            class="fa fa-check"></i> @lang('app.save')</button>
</div>

<script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>

<script>
    $(function () {
        $('.selectpicker').selectpicker({
            style: 'btn-info',
            size: 4
        });
    });

    $('#description').wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": true, //Button which allows you to edit the generated HTML. Default false
        "link": true, //Button to insert a link. Default true
        "image": true, //Button to insert an image. Default true,
        "color": true, //Button to change color of font
        stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)

    });

    $('#save-menu-form').click(function () {
        const form = $('#createMenuForm');

        $.easyAjax({
            url: '{{route('superadmin.footer-settings.updateFooterMenu', $footerMenu->id)}}',
            container: '#createMenuForm',
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#application-lg-modal').modal('hide');
                    table._fnDraw();
                }
            }
        })
    });
</script>
