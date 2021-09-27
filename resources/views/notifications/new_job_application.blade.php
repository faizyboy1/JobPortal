@if(isset($notification->data['data']['full_name']) && isset($notification->data['data']['job']['title']))
    <a href="{{ route('admin.job-applications.index') }}" class="dropdown-item text-sm">
        <i class="fa fa-users mr-2"></i>
        <span class="text-truncate-notify" style="overflow-y: hidden" title="full name"> {{ __('messages.notifications.newJobApplication', ['name' => $notification->data['data']['full_name'], 'job_title' => $notification->data['data']['job']['title']]) }}</span>
        <span class="float-right text-muted text-sm"></span>
        <div class="clearfix"></div>
    </a>
@endif