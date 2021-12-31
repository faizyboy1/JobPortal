<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-md-5">
                <h1 class="mb-xs-2">{{ __($pageTitle) }}</h1>
            </div>
            <div class="col-md-7">
                <span class="float-sm-right">@yield('create-button')</span>
                <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                    <li class="breadcrumb-item"><a
                        @if($user->is_superadmin)
                        href="{{ route('superadmin.dashboard.index') }}"
                            
                        @elseif($user->roles[0]->name == 'candidate')
                            href="{{ route('candidate.dashboard') }}"
                        @else
                        href="{{ route('admin.dashboard') }}"
                        @endif><i
                                    class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">{{ __($pageTitle) }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
