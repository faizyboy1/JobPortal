@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4>{!! $message !!}</h4>

                <p class="mt-4 mb-4">
                    <a href="{{ route('admin.subscribe.index') }}" class="btn btn-md btn-primary">@lang('modules.dashboard.upgrade')</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')


@endpush