@extends('layouts.offer')

@section('header-text')
    <h1 class="hidden-sm-down">  @if(!is_null($offer)) {{ ucwords($job->title)  }} @endif</h1>
    <h5 class="hidden-sm-down"><i class="icon-map-pin"></i> @if(!is_null($offer))  {{ ucwords($job->location->location) }} @endif</h5>
@endsection
@push('head-style')
    <style>
        .signature-pad {
            /*position: absolute;*/
            left: 0;
            top: 0;
            width:100%;
            height: 100%;
            background-color: white;
        }
        .hide-box{
            display: none;
        }
        .file-bg {
            height: 150px;
            overflow: hidden;
            position: relative;
        }
        .file-bg .overlay-file-box {
            opacity: .9;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            text-align: center;
        }
        .card-img-top {
            border-top-right-radius: calc(.25rem - 1px);
            border-top-left-radius: calc(.25rem - 1px);
        }
        .carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        .card{
            border: 1px solid #ccc;
        }
        .card-block {
            -webkit-box-flex: 1;
            -webkit-flex: 1 1 auto;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
        .card-title {
            margin-bottom: .75rem;
        }
    </style>
@endpush
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 fs-12 pt-50 pb-10 bb-1 mb-20">
                <a class="text-dark" >@lang('app.jobOffer')</a>
            </div>

            @if(!is_null($offer))
                <div class="col-md-8" id="">
                <div class="row gap-y">
                    <div class="col-md-12">
                        @if($job->company->show_in_frontend == 'true')
                            <small class="company-title">@lang('app.by') {{ ucwords($job->company->company_name) }}</small>
                        @endif
                        <h4 class="theme-color mt-20">@lang('app.candidate') @lang('app.detail')</h4>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.name')</h6>
                        <p>{{ ucwords($offer->applications->full_name) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.email')</h6>
                        <p>{{ ucwords($offer->applications->email) }}</p>
                    </div>
                    <div class="col-md-12">
                        <h4 class="theme-color mt-20">@lang('app.job') @lang('app.detail')</h4>
                    </div>
                    <div class="col-md-6">
                        <h6> @lang('app.title') </h6>
                        <p>{{ ucwords($job->title) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.description') </h6>
                        <p>{!! $job->job_description !!}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.requirement') </h6>
                        <p>{!! $job->job_requirement !!}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.location') </h6>
                        <p>{{ ucwords($job->location->location) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.category') </h6>
                        <p>{{ ucwords($job->category->name) }}</p>
                    </div>
                    <div class="col-md-12">
                        <h4 class="theme-color mt-20">@lang('app.offer') @lang('app.detail')</h4>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.designation') </h6>
                        <span>{{ ucwords($offer->department->name) }}</span> -> <span>{{ ucwords($offer->designation->name) }}</span>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.salaryOfferedPerMonth') </h6>
                        <p>{{ $offer->salary_offered }}</p>
                    </div>
                    <div class="col-md-6">
                         <h6>@lang('app.joiningDate') </h6>
                        <p>{{ $offer->joining_date->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.acceptLastDate') </h6>
                        <p>{{ $offer->accept_last_date->format('d M Y') }}</p>
                    </div>

                    <div class="col-md-12">
                        <h4 class="theme-color mt-20">@lang('app.files')</h4>

                        <div class="row">
                            @forelse($offer->files as $file)
                                <div class="col-md-3 m-b-10">
                                <a target="_blank" href="{{ asset_url('onboard-files/'.$file->hash_name) }}">
                                        <div class="card">
                                            <div class="file-bg">
                                                <div class="overlay-file-box">
                                                    <div class="user-content">
                                                        @if(array_key_exists($file->ext, $imageExt))
                                                            <img class="card-img-top img-responsive" src="{{ asset_url('onboard-files/'.$file->hash_name) }}" alt="Card image cap">
                                                        @else
                                                            <i class="fa {{ $fileExt[$file->ext]}}" style="font-size: -webkit-xxx-large; padding-top: 65px;"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-block">
                                                <h6 class="card-title">{{ $file->name }}</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty

                            @endforelse
                        </div>


                        @if($offer->hired_status == 'offered')
                        <div id="offeredBox">
                            <div class="my-30 text-center">
                                <a onclick="actionJobOffer('accept')" class="btn btn-lg btn-primary theme-background"
                                   href="javascript:;">@lang('app.accept')</a>
                                <a onclick="actionJobOffer('rejected')" class="btn btn-lg btn-primary theme-background"
                                   href="javascript:;">@lang('app.reject')</a>
                            </div>

                            <div class="col-xs-12 m-b-10 col-md-8"  id="signBox">
                                <div class="form-group">
                                    <label>@lang('app.signature')</label>
                                    <div class="wrapper form-control">
                                        <canvas id="signature-pad" class="signature-pad"></canvas>
                                    </div>

                                </div>
                                <div class="my-30 text-center">
                                    <button id="undo" class="btn btn-sm btn-primary "
                                    >@lang('app.undo')</button>
                                    <button id="clear" class="btn btn-sm btn-danger "
                                    >@lang('app.clear')</button>
                                </div>

                            </div>
                            <div class="col-xs-12 m-b-10 hide-box" id="reasonBox">
                                <div class="form-group">
                                    <label>@lang('app.reason')</label>
                                    <textarea class="form-control" rows="5" id="reason"></textarea>

                                </div>
                            </div>

                            <div class="my-30 text-center saveButton hide-box" >
                                <button class="btn btn-lg btn-success save-form"
                                        href="javascript:;">@lang('app.submit')</button>
                            </div>
                        </div>


                        @elseif($offer->hired_status == 'accepted')
                            <div class="col-xs-12" >
                                <img class="img-responsive" src="{{ asset_url('offer/sign/'.$offer->sign) }}" alt="Candidate Signiture">
                            </div>
                           <div class="alert alert-success my-100" role="alert">
                                 @lang('messages.acceptedOffer')
                           </div>
                        @else
                            <div class="alert alert-danger my-100" role="alert">
                                @lang('messages.rejectedOffer')
                            </div>
                        @endif
                    </div>

                </div>

            </div>
            @else
                <div class="col-md-8" >
                    <div class="row gap-y">
                        <div class="col-md-12">
                            <div class="alert alert-danger my-100" role="alert">
                                @lang('messages.noMatchFound')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('footer-script')
<script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
        actionType = '';
        code = '';
        @if(!is_null($offer))
            code = '{{ $offer->offer_code }}';
        @endif

        $(function () {
            var canvas = document.getElementById('signature-pad');

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
            function resizeCanvas() {
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            window.onresize = resizeCanvas;
            resizeCanvas();

            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
            });

            document.getElementById('clear').addEventListener('click', function (e) {
                e.preventDefault();
                signaturePad.clear();
            });

            document.getElementById('undo').addEventListener('click', function (e) {
                e.preventDefault();
                var data = signaturePad.toData();
                if (data) {
                    data.pop(); // remove the last dot or line
                    signaturePad.fromData(data);
                }
            });

            $('#signBox').hide();
        });

       function actionJobOffer (type) {
           actionType = type;
           console.log(actionType);
           if(actionType == 'accept'){
               $('#signBox').show();
               $('#reasonBox').hide();
           }
           else{
               $( "#clear" ).click();
               $('#signBox').hide();
               $('#reasonBox').show();
           }
           $('.saveButton').show();
        }

       $('.save-form').click(function () {
          var signature = '';
          var reason = $('#reason').val();
           if(actionType == 'accept'){
                signature = signaturePad.toDataURL('image/png');

               if (signaturePad.isEmpty()) {
                   return $.showToastr("Please provide a signature first.", 'error');
               }
           }
           else{
               if (reason === '' || reason === null || reason === undefined) {
                   return $.showToastr("Please provide a reason first.", 'error');
               }
           }

           $.easyAjax({
               url: '{{route('jobs.save-offer')}}',
               container: '#reasonBox',
               type: "POST",
               data: {
                   code: code,
                   type: actionType,
                   signature: signature,
                   reason: reason,
                   _token: '{{ csrf_token() }}'
               },
               success: function(data){
                   if(actionType == 'accept'){
                        var text = '<div class="alert alert-success my-100" role="alert"> @lang('messages.acceptedOffer') </div>';
                   }
                   else{
                        var text = '<div class="alert alert-danger my-100" role="alert"> @lang('messages.rejectedOffer') </div>';
                   }

                    $('#offeredBox').html(text);
               }
           })
       });

    </script>
@endpush