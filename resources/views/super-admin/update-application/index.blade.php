@extends('layouts.app')

@section('content')

    <div class="row">

        @include('vendor.froiden-envato.update.update_blade')
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('vendor.froiden-envato.update.version_info')

                        </div>
                    </div>


                    <hr>
                    <!--row-->
                @include('vendor.froiden-envato.update.changelog')
                @include('vendor.froiden-envato.update.plugins')
                <!--/row-->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-script')
    @include('vendor.froiden-envato.update.update_script')

@endpush
