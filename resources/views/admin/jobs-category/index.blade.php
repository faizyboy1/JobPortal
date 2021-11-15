@extends('layouts.app') @push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush 


    @section('create-button')
    <a href="{{ route('superadmin.job-category.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
    @endsection


@section('content')

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="icon-badge"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.totalCategory')</span>
                <span class="info-box-number">{{ number_format($totalCategory) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('modules.accountSettings.companyName')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($categories as $data)
                                <tr> 
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->company_name}}</td>

                                    <td class="row pl-4">
                                        <a title="Edit" href="{{url('super-admin/job-category/'.$data->id.'/edit')}}" class="btn btn-primary btn-circle" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ url('super-admin/job-category', ['id' => $data->id]) }}" method="post">
                                            <button class="btn btn-danger btn-circle ml-1" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Confirm! Delete.')" type="submit" value="">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            @method('delete')
                                            @csrf
                                        </form>          
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer-script')
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>



@endpush
