<form id="editSettings" class="ajax-form" data-language-id="{{ $headerData->language_settings_id }}">
    @csrf
    <div class="form-group">
        <label>@lang('modules.frontCms.title')</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $headerData->title }}">
    </div>
    <div class="form-group">
        <label>@lang('modules.frontCms.description')</label>
        <textarea name="description" class="form-control" id="description" cols="30" rows="4">{!! $headerData->description !!}</textarea>
    </div>
    <div class="form-group">
        <label>@lang('modules.frontCms.callToActionTitle')</label>
        <input class="form-control" id="call_to_action_title" name="call_to_action_title" value="{{ $headerData->call_to_action_title }}">
    </div>
    <div class="form-group">
        <label>@lang('modules.frontCms.contactText')</label>
        <textarea name="contact_text" id="contact_text" class="form-control" cols="30" rows="6">{!! $headerData->contact_text !!}</textarea>
    </div>
    <div class="form-group">
        <label>@lang('modules.frontCms.headerImage')</label>
        <div class="card">
            <div class="card-body">
                <input type="file" id="header_image" name="header_image" class="dropify" data-default-file="{{ $headerData->header_image_url }}"  />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>@lang('modules.frontCms.headerBackroundImage')</label>
        <div class="card">
            <div class="card-body">
                <input type="file" id="header_backround_image" name="header_backround_image" class="dropify" data-default-file="{{ $headerData->header_backround_image_url }}"  />
            </div>
            <input type="hidden" name="remove_header_background" id="remove_header_background" value="no">
        </div>
    </div>
    
    <h4 class="card-title">@lang('modules.frontCms.seoSettings')</h4>
    <div class="form-group">
        <label for="meta_title" class="control-label">@lang('modules.frontCms.metaTitle')</label>
        <input class="form-control" id="meta_title" name="meta_details[title]" value="{{ $headerData->meta_details['title'] }}">
    </div>
    <div class="form-group">
        <label for="meta_description" class="control-label">@lang('modules.frontCms.metaDescription')</label>
        <textarea name="meta_details[description]" id="meta_description" class="form-control" cols="30" rows="3">{!! $headerData->meta_details['description'] !!}</textarea>
    </div>
    <div class="form-group">
        <label for="meta_keywords" class="control-label">@lang('modules.frontCms.metaKeywords')</label>
        <textarea name="meta_details[keywords]" id="meta_keywords" class="form-control" cols="30" rows="3">{!! $headerData->meta_details['keywords'] !!}</textarea>
    </div>

    <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
            @lang('app.save')
        </button>
    <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
</form>