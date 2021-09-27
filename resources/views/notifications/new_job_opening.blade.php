<a href="{{ route('admin.jobs.index') }}" class="dropdown-item text-sm">
    <i class="fa fa-users mr-2"></i>
    <span class="text-truncate-notify" style="overflow-y: hidden" title="full name">{{ __('messages.notifications.newJobOpening', ['title' => $notification->data['data']['title']]) }}</span>
    <span class="float-right text-muted text-sm">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}</span>
    <div class="clearfix"></div>
</a>