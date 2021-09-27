@extends('layouts.saas-front')

@push('meta_details')
    <title>{{ 'Recruit | '.$footerMenu->name ?: 'Recruit' }}</title>

    <meta name="title" content="{{ $footerMenu->seo_details->seo_title ?: '' }}">
    <meta name="description" content="{{ $footerMenu->seo_details->seo_description ?: '' }}">
    <meta name="keywords" content="{{ $footerMenu->seo_details->seo_keywords ?: '' }}">
@endpush

@push('header_css')
    <style>
        .page {
            min-height: 60vh;
        }
    </style>
@endpush

@section('content')
    <section class="page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h1>{!! $footerMenu->name !!}</h1>
                </div>
                <div class="col-md-12">
                    <p>{!! $footerMenu->description !!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection