@if($section_visibility['profile_image'] == 'yes')
    <div class="row b-b">
        <div class="col-md-8 offset-md-4">
            <div class="form-group">
                <label class="control-label required"> <strong>
                        @lang('modules.front.photo')
                    </strong></label>
                <input class="form-control select-file" accept=".png,.jpg,.jpeg" type="file" name="photo"><br>
                <span>@lang('modules.front.photoFileType')</span>
            </div>
            @if(!empty($application) && !is_null($application->photo))
                <p>
                    <a target="_blank" href="{{ asset('user-uploads/candidate-photos/'.$application->photo) }}" class="btn btn-sm btn-primary">@lang('app.view')</a>
                </p>
            @endif
        </div>
    </div>

@endif

<div class="row b-b">
    @if($section_visibility['resume'] == 'yes')
        <div class="col-md-4 pl-4 pr-4 pb-4 pt-4 b-b">
            <h5 > @lang('modules.front.resume') <span class="required-field">*</span></h5>
        </div>
        
        
        <div class="col-md-8 pb-4 pt-4 b-b">
            <div class="form-group">
                <input class="select-file" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.rtf" type="file"
                    name="resume"><br>
                <span>@lang('modules.front.resumeFileType')</span>
            </div>
            @if (!empty($application) && $application->resume_url)
                <p>
                    <a target="_blank" href="{{ $application->resume_url }}" class="btn btn-sm btn-primary">
                        @lang('app.view')
                    </a>
                </p>
            @endif
        </div>
    @endif
    @if($section_visibility['cover_letter'] == 'yes')
        <div class="col-md-4 pl-4 pr-4 pt-4 b-b">
            <h5>@lang('modules.front.coverLetter')</h5>
        </div>
        
        
        <div class="col-md-8 pt-4 b-b">
        
            <div class="form-group">
                <textarea class="form-control" name="cover_letter" rows="4">{{ !empty($application) ? $application->city : '' }}</textarea>
            </div>
        </div>
    @endif
</div>