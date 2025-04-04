@extends('user-front.layout')
@section('tab-title')
    {{ 'Downloads' }}
@endsection
@php
    Config::set('app.timezone', $userBs->timezoneinfo->timezone ?? '');
@endphp
@section('meta-description', !empty($userSeo) ? $userSeo->home_meta_description : '')
@section('meta-keywords', !empty($userSeo) ? $userSeo->home_meta_keywords : '')
@section('page-name')
    {{ $keywords['Downloads'] ?? 'Downloads' }}
@endsection
@section('br-name')
    {{ $keywords['Downloads'] ?? 'Downloads' }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    @foreach($pdf as $file)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <a href="{{ asset('assets/user/files/' . $file->image) }}" target="_blank">
                                    <i class="fas fa-file-pdf" style="font-size: 4rem; color: red;"></i>
                                </a>
                                <div class="card-body">
                                    <p>{{ $file->alt_text }}</p>
                                </div>
                                <div class="card-body">
                                    <a href="{{ asset('assets/user/files/' . $file->image) }}" download class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection