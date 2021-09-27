@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('menu.clientFeedbacks')</h4>

                <form id="editSettings" class="ajax-form" >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <select name="language" class="form-control selectpicker" id="language_switcher">
                            @forelse ($activeLanguages as $language)
                            <option
                                @if($language->id === $feedback->language_settings_id) selected @endif
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
                        <label>@lang('modules.frontCms.feedback')</label>
                        <textarea name="feedback" class="form-control" id="feedback" cols="30"
                    rows="4">{{ $feedback->feedback }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('modules.frontCms.clientTitle')</label>
                        <input type="text" class="form-control" id="client_title" name="client_title" value="{{ $feedback->client_title }}">
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


<script>

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.client-feedbacks.update", $feedback->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
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

                    var url = "{{ route('superadmin.client-feedbacks.destroy',':id') }}";
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