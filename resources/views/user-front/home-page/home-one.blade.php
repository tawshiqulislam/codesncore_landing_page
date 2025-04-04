@extends('user-front.layout')

@section('tab-title')
    {{ $keywords['Home'] ?? 'Home' }}
@endsection
@php
    Config::set('app.timezone', $userBs->timezoneinfo->timezone);
@endphp
@section('meta-description', !empty($userSeo) ? $userSeo->home_meta_description : '')
@section('meta-keywords', !empty($userSeo) ? $userSeo->home_meta_keywords : '')

@section('content')
    <!--====== Banner part start ======-->
    <section class="banner-section" style="height:100%">
        <div class="banner-slider" id="bannerSlider">
            @if (count($sliders) > 0)
                @foreach ($sliders as $slider)
                <div>
                    <div class="single-banner lazy" data-bg="{{ asset('assets/front/img/hero_slider/' . $slider->img) }}">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="banner-content">
                                        <span class="promo-text" data-animation="fadeInDown" data-delay="0.8s">
                                            {{ $slider->title }}
                                        </span>
                                        <h1 data-animation="fadeInUp" data-delay="1s" style="font-size: xxx-large;">
                                            {{ $slider->subtitle }}
                                        </h1>
                                        @if (!empty($slider->btn_url))
                                            <ul class="btn-wrap">
                                                <li data-animation="fadeInLeft" data-delay="1.2s">
                                                    <a href="{{ $slider->btn_url }}"
                                                        class="main-btn main-btn-4">{{ $slider->btn_name }}</a>
                                                </li>
                                            </ul>
                                            {{-- new for cnc // Products \\ --}}
                                            @if(getUser()->id == 169)
                                            <ul class="btn-wrap">
                                                <li data-animation="fadeInLeft" data-delay="1.2s">
                                                    <a href="{{ url('/' . 'cnc/quote/products') }}"
                                                        class="main-btn main-btn-4">{{ 'Our Products' }}</a>
                                                </li>
                                            </ul>
                                            @endif
                                            {{-- end new for cnc // Products \\ --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="banner-shapes">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                            <div class="four"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="single-banner lazy" data-bg="{{ asset('assets/front/img/hero_slider/hero_bg.jpg') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="banner-content">
                                    <span class="promo-text" data-animation="fadeInDown" data-delay="0.8s">
                                        business & consulting 
                                    </span>
                                    <h1 data-animation="fadeInUp" data-delay="1s">
                                        Making Difference, Grow Your Business With Modern Ideas
                                    </h1>
                                    <ul class="btn-wrap">
                                        <li data-animation="fadeInLeft" data-delay="1.2s">
                                            <a href="#" class="main-btn main-btn-4">Our Services</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="banner-shapes">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                            <div class="four"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--====== Banner part end ======-->

    <!--====== Client Area Start ======-->
    @if (isset($home_sections->brand_section) && $home_sections->brand_section == 1 && count($brands) > 0)
        <section class="client-section">
            <div class="container">
                <!-- Section Title -->
                <div class="section-title text-center both-border mt-80 mb-0">
                    <h2 class="title">{{ 'Our Valueable Customers' }}</h2>
                </div>
                <!-- Services Boxes -->
                <div class="client-slider section-gap line-bottom">
                    <div class="row align-items-center justify-content-between" id="clientSlider">
                        @foreach ($brands as $brand)
                            <div class="col">
                                <a href="{{ $brand->brand_url }}" class="client-img d-block text-center"
                                    target="_blank">
                                    <img class="lazy"
                                        data-src="{{ asset('assets/front/img/user/brands/' . $brand->brand_img) }}"
                                        alt="">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--====== Client Area End ======-->

    <!--====== About Section start ======-->
    @if (isset($home_sections->intro_section) && $home_sections->intro_section == 1)
        <section class="about-section about-illustration-img section-gap">
            <div class="container">
                @php
                    $aboutImg = $home_text->about_image ?? 'about.png';
                @endphp
                <div class="row no-gutters justify-content-lg-end justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <img class="lazy" data-src="{{ asset('assets/front/img/user/home_settings/' . $aboutImg) }}"
                            alt="Image">
                    </div>
                    <div class="col-lg-6">
                        <div class="about-text">
                            <div class="section-title left-border mb-40">
                                @if (!empty($home_text->about_title))
                                    <span class="title-tag">{{ $home_text->about_title }}</span>
                                @endif
                                <h2 class="title">{{ $home_text->about_subtitle ?? null }}</h2>
                            </div>
                            @if (!empty($home_text->about_content))
                            <p class="mb-25">
                                {!! nl2br($home_text->about_content) ?? null !!}
                            </p>
                            @endif
                            @if (!empty($home_text->about_button_url))
                            <a href="{{$home_text->about_button_url}}" class="main-btn">{{$home_text->about_button_text}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--====== About Section end ======-->

    @if (in_array('Service', $packagePermissions) &&
            isset($home_sections->featured_services_section) &&
            $home_sections->featured_services_section == 1)
        <!--====== Service Part Start ======-->
        <section class="service-section shape-style-one section-gap grey-bg">
            <div class="container">
                <!-- Section Title -->
                <div class="section-title text-center both-border mb-30">
                    @if (!empty($home_text->service_title))
                        <span class="title-tag">{{ $home_text->service_title }}</span>
                    @endif
                    <h2 class="title">{{ $home_text->service_subtitle ?? null }}</h2>
                </div>
                <!-- Services Boxes -->
                <div class="row service-boxes justify-content-center">
                    @foreach ($services as $service)
                        <div class="col-lg-4 col-md-6 col-sm-8 col-10 col-tiny-12 wow fadeInLeft" data-wow-duration="1500ms"
                            data-wow-delay="400ms">
                            <div class="service-box text-center">
                                <span class="badge badge-service">Service</span>
                                <a class="icon"
                                @if($service->detail_page == 1)
                                href="{{route('front.user.service.detail',[getParam(),'slug' => $service->slug,'id' => $service->id])}}"
                                @endif>
                                    <img class="lazy" data-src="{{isset($service->image) ? asset('assets/front/img/user/services/'.$service->image) : asset('assets/front/img/profile/service-1.jpg')}}" alt="Icon">
                                </a>
                                <h3>
                                    <a
                                        @if ($service->detail_page == 1) href="{{ route('front.user.service.detail', [getParam(), 'slug' => $service->slug, 'id' => $service->id]) }}" @endif>{{ $service->name }}</a>
                                </h3>
                                <p>{!! strlen(strip_tags($service->content)) > 80
                                    ? mb_substr(strip_tags($service->content), 0, 80, 'UTF-8') . '...'
                                    : strip_tags($service->content) !!}</p>
                                @if ($service->detail_page == 1)
                                    <a href="{{ route('front.user.service.detail', [getParam(), 'slug' => $service->slug, 'id' => $service->id]) }}"
                                        class="service-link">
                                        <i class="fal fa-long-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="col-12 my-5 text-center">
                        <a href="" class="btn btn-info">View All Services</a>
                    </div> --}}

                    @if($q_products != null)
                    @foreach ($q_products as $service)
                        <div class="col-lg-4 col-md-6 col-sm-8 col-10 col-tiny-12 wow fadeInLeft" data-wow-duration="1500ms"
                            data-wow-delay="400ms">
                            <div class="service-box text-center">
                                <span class="badge badge-product">Product</span>
                                <a class="icon"
                                @if($service->detail_page == 1)
                                href="{{route('front.user.q_products.detail',[getParam(),'slug' => $service->slug,'id' => $service->id])}}"
                                @endif>
                                    <img class="lazy" data-src="{{isset($service->image) ? asset('assets/front/img/user/products/'.$service->image) : asset('assets/front/img/profile/service-1.jpg')}}" alt="Icon">
                                </a>
                                <h3>
                                    <a
                                        @if ($service->detail_page == 1) href="{{ route('front.user.q_products.detail', [getParam(), 'slug' => $service->slug, 'id' => $service->id]) }}" @endif>{{ $service->name }}</a>
                                </h3>
                                <p>{!! strlen(strip_tags($service->content)) > 80
                                    ? mb_substr(strip_tags($service->content), 0, 80, 'UTF-8') . '...'
                                    : strip_tags($service->content) !!}</p>
                                @if ($service->detail_page == 1)
                                    <a href="{{ route('front.user.service.detail', [getParam(), 'slug' => $service->slug, 'id' => $service->id]) }}"
                                        class="service-link">
                                        <i class="fal fa-long-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="col-12 my-5 text-center">
                        <a href="" class="btn btn-info">View All Products</a>
                    </div> --}}
                    @endif
                </div>
            </div>
            {{-- new for cnc --}}
            {{-- <div class="dots-line">
                <img src="{{ asset('assets/front/user/img/lines/07.png') }}" alt="Image">
            </div> --}}
        </section>
        <!--====== Service Part End ======-->
    @endif

    <!--====== Video Start ======-->
    @if (isset($home_sections->video_section) && $home_sections->video_section == 1)
        @php
            $videoBg = $videoSectionDetails->video_section_image ?? 'video_bg_one.jpg';
            $isVideo = !empty($home_text->video_section_url) && (str_contains($home_text->video_section_url, 'youtube.com') || str_contains($home_text->video_section_url, 'youtu.be'));
            $isSlideshow = !empty($home_text->video_section_url) && !$isVideo;
            $slides = $isSlideshow ? explode(',', $home_text->video_section_url) : [];
        @endphp

        <!-- Popup Structure -->
        <div class="custom-popup-wrapper">
            <div class="custom-popup-content">
                <span class="custom-popup-close">&times;</span>
                @if($isVideo)
                    <iframe class="custom-popup-video" allowfullscreen></iframe>
                @elseif($isSlideshow)
                    <div class="custom-slider-container">
                        @foreach($slides as $index => $slide)
                            <div class="custom-slide @if($index === 0) active @endif">
                                <img src="{{ asset('assets/front/img/user/video_slides/' . $slide) }}" 
                                    alt="Slide {{ $index + 1 }}" class="custom-slide-image">
                            </div>
                        @endforeach
                        <button class="custom-slider-prev" @if(count($slides) <= 1) hidden @endif>&#10094;</button>
                        <button class="custom-slider-next" @if(count($slides) <= 1) hidden @endif>&#10095;</button>
                    </div>
                @endif
            </div>
        </div>

        <section class="video-section bg-img-c section-gap lazy"
            data-bg="{{ asset('assets/front/img/user/home_settings/' . $videoBg) }}">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-7 col-lg-8 col-md-10 order-2 order-md-1">
                        <div class="video-text">
                            <div class="section-title left-border mb-30">
                                @if (!empty($videoSectionDetails->video_section_title))
                                    <span class="title-tag">{{ $videoSectionDetails->video_section_title }}</span>
                                @endif
                                <h2 class="title">
                                    {{ $videoSectionDetails->video_section_subtitle ?? null }}
                                </h2>
                            </div>
                            @if (!empty($videoSectionDetails->video_section_text))
                                <p>
                                    {!! nl2br($videoSectionDetails->video_section_text) !!}
                                </p>
                            @endif
                            @if (!empty($videoSectionDetails->video_section_button_url))
                                <a href="{{ $videoSectionDetails->video_section_button_url }}"
                                    class="main-btn">{{ $videoSectionDetails->video_section_button_text }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-4 col-md-2 order-1 order-md-2">
                        <div class="video-btn text-md-center wow fadeInUp" data-wow-duration="1500ms"
                            data-wow-delay="400ms">
                            @if (!empty($home_text->video_section_url))
                                <a href="javascript:void(0)" class="play-btn custom-popup-trigger">
                                    <img src="{{ asset('assets/front/user/img/icons/play.svg') }}" alt="">
                                    <i class="fas fa-play"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/front/user/img/lines/08.png') }}" alt="Line">
            </div>
        </section>
    @endif
    <!--====== Video end ======-->


    <!--====== Video/Slideshow Start ======-->
    {{-- @if (isset($home_sections->video_section) && $home_sections->video_section == 1)
    @php
        $videoBg = $videoSectionDetails->video_section_image ?? 'video_bg_one.jpg';
        $isVideo = !empty($home_text->video_section_url) && (str_contains($home_text->video_section_url, 'youtube.com') || str_contains($home_text->video_section_url, 'youtu.be'));
        $isSlideshow = !empty($home_text->video_section_url) && !$isVideo;
    @endphp

    <section class="vsl-section bg-img-c section-gap lazy" 
            data-bg="{{ asset('assets/front/img/user/home_settings/' . $videoBg) }}">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-7 col-lg-8 col-md-10 order-2 order-md-1">
                    <div class="vsl-text">
                        <div class="section-title left-border mb-30">
                            @if (!empty($videoSectionDetails->video_section_title))
                                <span class="vsl-tag">{{ $videoSectionDetails->video_section_title }}</span>
                            @endif
                            <h2 class="vsl-title">
                                {{ $videoSectionDetails->video_section_subtitle ?? null }}
                            </h2>
                        </div>
                        @if (!empty($videoSectionDetails->video_section_text))
                            <p class="vsl-desc">
                                {!! nl2br($videoSectionDetails->video_section_text) !!}
                            </p>
                        @endif
                        @if (!empty($videoSectionDetails->video_section_button_url))
                            <a href="{{ $videoSectionDetails->video_section_button_url }}"
                                class="vsl-btn">{{ $videoSectionDetails->video_section_button_text }}</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-lg-4 col-md-2 order-1 order-md-2">
                    <div class="vsl-media-wrap">
                        @if ($isVideo)
                            <div class="vsl-video-btn text-md-center wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="400ms">
                                <a href="{{ $home_text->video_section_url }}" class="vsl-play-btn popup-video">
                                    <img src="{{ asset('assets/front/user/img/icons/play.svg') }}" alt="">
                                    <i class="fas fa-play vsl-play-icon"></i>
                                </a>
                            </div>
                        @elseif ($isSlideshow)
                            <div class="vsl-slideshow">
                                @php
                                    $slides = explode(',', $home_text->video_section_url);
                                @endphp
                                <div class="vsl-slideshow-container">
                                    @foreach($slides as $index => $slide)
                                        <div class="vsl-slide @if($index === 0) vsl-active @endif">
                                            <img src="{{ asset('assets/front/img/user/video_slides/' . $slide) }}" 
                                                alt="Slide {{ $index + 1 }}" class="vsl-slide-img">
                                        </div>
                                    @endforeach
                                    <button class="vsl-slide-prev"><i class="fas fa-chevron-left vsl-slide-icon"></i></button>
                                    <button class="vsl-slide-next"><i class="fas fa-chevron-right vsl-slide-icon"></i></button>
                                </div>
                                <div class="vsl-slide-dots">
                                    @foreach($slides as $index => $slide)
                                        <span class="vsl-dot @if($index === 0) vsl-dot-active @endif" data-index="{{ $index }}"></span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="vsl-line-shape">
            <img src="{{ asset('assets/front/user/img/lines/08.png') }}" alt="Line">
        </div>
    </section>
    @endif --}}
    <!--====== Video/Slideshow End ======-->

    @if (in_array('Portfolio', $packagePermissions) &&
            isset($home_sections->portfolio_section) &&
            $home_sections->portfolio_section == 1)
        <!--====== Portfolio Part start ======-->
        <section class="feature-section section-gap">
            <div class="container">
                <div class="section-title text-center both-border mb-50">
                    @if (!empty($home_text->portfolio_title))
                        <span class="title-tag"> {{ $home_text->portfolio_title }} </span>
                    @endif
                    <h2 class="title">{{ $home_text->portfolio_subtitle ?? null }}</h2>
                </div>
                <!-- Feature boxes -->
                <div class="feature-boxes row justify-content-center">
                    @foreach ($portfolios as $portfolio)
                        <div class="col-lg-4 col-md-6 col-10 col-tiny-12">
                            <div class="feature-box">
                                <a href="{{ route('front.user.portfolio.detail', [getParam(), $portfolio->slug, $portfolio->id]) }}"
                                    class="feature-bg bg-img-c lazy"
                                    data-bg="{{ asset('assets/front/img/user/portfolios/' . $portfolio->image) }}">
                                </a>
                                <div class="feature-desc">
                                    <a href="{{ route('front.user.portfolio.detail', [getParam(), $portfolio->slug, $portfolio->id]) }}"
                                        class="feature-link"><i class="fal fa-long-arrow-right"></i></a>
                                    <a href="{{ route('front.user.portfolio.detail', [getParam(), $portfolio->slug, $portfolio->id]) }}"
                                        class="feature-link d-block mb-0">
                                        <h4>{{ strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'UTF-8') . '...' : $portfolio->title }}
                                        </h4>
                                    </a>

                                    <p>{{$portfolio->bcategory->name}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
        </section>
        <!--====== Portfolio Part end ======-->
    @endif

    <!--====== Why Choose Us Part Start ======-->
    @if (isset($home_sections->why_choose_us_section) && $home_sections->why_choose_us_section == 1)
        @php
            $whyChooseImg = $home_text->why_choose_us_section_image ?? 'why_choose_us.png';
        @endphp
        <section class="wcu-section box-style">
            <div class="container">
                <div class="wcu-inner">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6">
                            <div class="wcu-image text-center text-lg-left wow fadeInUp" data-wow-duration="1500ms"
                                data-wow-delay="400ms">
                                <img data-src="{{ asset('assets/front/img/user/home_settings/' . $whyChooseImg) }}"
                                    alt="Image" class="lazy">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-10">
                            <div class="wcu-text">
                                <div class="section-title left-border mb-40">
                                    @if (!empty($home_text->why_choose_us_section_title))
                                        <span class="title-tag">{{ $home_text->why_choose_us_section_title }}</span>
                                    @endif
                                    <h2 class="title">{{ $home_text->why_choose_us_section_subtitle ?? null }}</h2>
                                </div>
                                @if (!empty($home_text->why_choose_us_section_text))
                                    <p class="mb-4">
                                        {!! nl2br($home_text->why_choose_us_section_text) !!}
                                    </p>
                                @endif
                                @if (!empty($home_text->why_choose_us_section_button_url))
                                    <a href="{{ $home_text->why_choose_us_section_button_url }}"
                                        class="main-btn main-btn-4"
                                        target="_blank">{{ $home_text->why_choose_us_section_button_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <img data-src="{{ asset('assets/front/user/img/lines/03.png') }}" alt="shape"
                        class="line-shape-one lazy">
                    <img data-src="{{ asset('assets/front/user/img/lines/04.png') }}" alt="shape"
                        class="line-shape-two lazy">
                </div>
            </div>
        </section>
    @endif
    <!--====== Why Choose Us Part End ======-->

    <!--====== Fact Part Start ======-->
    @if (isset($home_sections->counter_info_section) && $home_sections->counter_info_section == 1)
        <section class="fact-section grey-bg" style="border: 1px solid #0093D8; background:#0093D8; width: 100%; padding-top: 10px; margin: 0px;">
            <div class="container">
                <div class="counter-inner">
                    <div class="fact-boxes row justify-content-between align-items-center">
                        {{-- @dd($counterInformations[0]['count']); --}}
                        @foreach ($counterInformations as $key => $counterInformation)
                        
                        @if($key == 0)
                            <div class="col-lg-3 col-6" style="margin-top: 1rem;">
                                <div class="fact-box text-center mb-40">
                                    <div class="icon">
                                        <img src="{{ asset('assets/front/img/counter/00.png') }}" alt="">
                                    </div>
                                    <h3 style="color: rgb(255, 255, 255)">{{ number_format($counterInformation->count) . '+ Years of Expertise'}}</h3>
                                    <p class="title" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; color:white; font-size: smaller; font-weight: 200;">{{ $counterInformation->title }}</p>
                                </div>
                            </div>
                        @elseif($key == 1)
                            <div class="col-lg-3 col-6" style="margin-top: -1rem;">
                                <div class="fact-box text-center mb-40">
                                    <div class="icon">
                                        <img src="{{ asset('assets/front/img/counter/01.png') }}" alt="">
                                    </div>
                                    <h3 style="color: rgb(255, 255, 255)">{{ number_format($counterInformation->count) . 'sq. ft. Facilities'}}</h3>
                                    <p class="title" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; color:white; font-size: smaller; font-weight: 200;">{{ $counterInformation->title }}</p>
                                </div>
                            </div>
                        @elseif($key == 2)
                            <div class="col-lg-3 col-6" style="margin-top: 2rem;">
                                <div class="fact-box text-center mb-40">
                                    <div class="icon">
                                        <img src="{{ asset('assets/front/img/counter/02.png') }}" alt="">
                                    </div>
                                    <h3 style="color: rgb(255, 255, 255)">{{ number_format($counterInformation->count) . '+ Skilled Professionals' }}</h3>
                                    <p class="title" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; color:white; font-size: smaller; font-weight: 200;">{{ $counterInformation->title }}</p>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-3 col-6">
                                <div class="fact-box text-center mb-40">
                                    <div class="icon">
                                        <i class="{{ $counterInformation->icon }}"></i>
                                    </div>
                                    <h2 class="counter" style="color: rgb(255, 255, 255)">{{ number_format($counterInformation->count) }}</h2>
                                    <p class="title" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; color:white; font-size: smaller; font-weight: 200;">{{ $counterInformation->title }}</p>
                                </div>
                            </div>
                        @endif   
                        @endforeach
                    </div>
                </div>
                
            </div>
        </section>
    @endif
    <!--====== Fact Part End ======-->

    <!--====== Team Section Start ======-->
    @if (in_array('Team', $packagePermissions) &&
            isset($home_sections->team_members_section) &&
            $home_sections->team_members_section == 1)
        <section class="team-section section-gap">
            <div class="container">
                <!-- Section Title -->
                <div class="section-title mb-40 both-border text-center">
                    @if (!empty($home_text->team_section_title))
                        <span class="title-tag">{{ $home_text->team_section_title }}</span>
                    @endif
                    <h2 class="title">{{ $home_text->team_section_subtitle ?? null }}</h2>
                </div>

                <!-- Team Boxes -->
                <div class="team-members" id="teamSliderOne">
                    @foreach ($teams as $team)
                        <div class="team-member">
                            <div class="member-picture-wrap">
                                <div class="member-picture">
                                    <img src="{{ asset('/assets/front/img/user/team/' . $team->image) }}"
                                        alt="TeamMember">
                                    <div class="social-icons">
                                        @isset($team->facebook)
                                            <a href="{{ $team->facebook }}">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        @endisset
                                        @isset($team->twitter)
                                            <a href="{{ $team->twitter }}">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endisset
                                        @isset($team->instagram)
                                            <a href="{{ $team->instagram }}">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endisset
                                        @isset($team->linkedin)
                                            <a href="{{ $team->linkedin }}">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            <div class="member-desc">
                                <h3 class="name"><a href="javascript:void(0)">{{ $team->name }}</a></h3>
                                <span class="pro">{{ $team->rank }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--====== Team Section End ======-->

    <!--====== Skill Section Start ======-->
    @if (0==1 && isset($home_sections->skills_section) && $home_sections->skills_section == 1)
        <section class="skill-section">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-10">
                        <!-- Skill Text Block -->
                        <div class="skill-text">
                            <div class="section-title mb-40 left-border">
                                @if (!empty($home_text->skills_title))
                                    <span class="title-tag">{{ $home_text->skills_title }}</span>
                                @endif
                                <h2 class="title">{{ $home_text->skills_subtitle ?? null }}</h2>
                            </div>
                            @if (!empty($home_text->skills_content))
                                <p>{!! nl2br($home_text->skills_content ?? '') !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-10">
                        <div class="piechart-boxes">
                            @foreach ($skills as $skill)
                                <div class="chart-box">
                                    <div class="chart" data-percent="{{ $skill->percentage }}"
                                        data-bar-color="#{{ $skill->color }}">
                                        <i class="{{ $skill->icon ?? 'fa fa-fw fa-heart' }}"></i>
                                    </div>
                                    <h4 class="title">{{ $skill->title }}</h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--====== Skill Section End ======-->

    <!--====== Testimonials part start ======-->
    @if (isset($home_sections->testimonials_section) && $home_sections->testimonials_section == 1)
        <section class="testimonial-section grey-bg">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-start">
                    <div class="col-lg-6 col-md-10 offset-lg-5">
                        <div class="section-title left-border">
                            @if (!empty($home_text->testimonial_title))
                                <span class="title-tag">{{ $home_text->testimonial_title }}</span>
                            @endif
                            <h2 class="title">{{ $home_text->testimonial_subtitle ?? null }}</h2>
                        </div>
                        <div class="testimonial-items" id="testimonialSliderOne">
                            @foreach ($testimonials as $testimonial)
                                <div class="testimonial-item">
                                    <div class="content">
                                        <p>
                                            <span class="quote-top">
                                                <i class="fas fa-quote-left"></i>
                                            </span>
                                            {{ replaceBaseUrl($testimonial->content) }}
                                            <span class="quote-bottom">
                                                <i class="fas fa-quote-right"></i>
                                            </span>
                                        </p>

                                    </div>
                                    <div class="author">
                                        <div class="thumb">
                                            <img class="lazy"
                                                data-src="{{ asset('assets/front/img/user/testimonials/' . $testimonial->image) }}"
                                                alt="img">
                                        </div>
                                        <div class="desc">
                                            <h4>{{ $testimonial->name }}</h4>
                                            <span>{{ $testimonial->occupation ?? null }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="testimonial-arrows row"></div>
                    </div>
                </div>
            </div>
            @php
                $tstmImg = $home_text->testimonial_image ?? 'testimonial.png';
            @endphp
            <!-- Testimonials img -->
            <div class="testimonial-img">
                <img class="lazy" data-src="{{ asset('assets/front/img/user/home_settings/' . $tstmImg) }}"
                    alt="testimonial">
            </div>
        </section>
    @endif
    <!--====== Testimonials part end ======-->

    @if (in_array('Blog', $packagePermissions) && isset($home_sections->blogs_section) && $home_sections->blogs_section == 1)
        <!--====== Latest Post Start ======-->
        <section class="latest-post-section section-gap">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-8 col-10 col-tiny-12">
                        <div class="section-title left-border">
                            @if (!empty($home_text->blog_title))
                                <span class="title-tag">{{ $home_text->blog_title }}</span>
                            @endif
                            <h2 class="title">{{ $home_text->blog_subtitle ?? null }}</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 col-10 col-tiny-12">
                        <div class="text-md-right mt-30 mt-md-0">
                            <a href="{{ route('front.user.blogs', getParam()) }}"
                                class="main-btn">{{ $home_text->view_all_blog_text ?? 'View All' }}</a>
                        </div>
                    </div>
                </div>
                <div class="latest-post-loop row mt-50 justify-content-center">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-4 col-md-6 col-10 col-tiny-12 wow fadeInLeft" data-wow-duration="1500ms"
                            data-wow-delay="400ms">
                            <div class="latest-post-box">
                                <div class="post-thumb-wrap">
                                    <a class="post-thumb bg-img-c lazy"
                                        href="{{ route('front.user.blog.detail', [getParam(), $blog->slug, $blog->id]) }}"
                                        data-bg="{{ asset('assets/front/img/user/blogs/' . $blog->image) }}">
                                    </a>
                                </div>
                                <div class="post-desc">
                                    <span class="post-date"><i
                                            class="far fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y') }}</span>
                                    <h3 class="title">
                                        <a
                                            href="{{ route('front.user.blog.detail', [getParam(), $blog->slug, $blog->id]) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    <p>
                                        {!! strlen(strip_tags($blog->content)) > 80
                                            ? mb_substr(strip_tags($blog->content), 0, 80, 'UTF-8') . '...'
                                            : strip_tags($blog->content) !!}
                                    </p>
                                    <a href="{{ route('front.user.blog.detail', [getParam(), $blog->slug, $blog->id]) }}"
                                        class="post-link">
                                        {{ $keywords['Learn_More'] ?? 'Learn More' }}
                                        <i class="far fa-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--====== Latest Post Start ======-->
    @endif

    <style>
        .col-12.order-1.slick-arrow {
            position: absolute !important;
            margin-top: 5rem;
        }

        .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            z-index: 1;
        }

        .badge-service {
            background-color: #007bff; /* Blue for Service */
        }

        .badge-product {
            background-color: #28a745; /* Green for Product */
        }

        .service-box {
            position: relative; /* Ensure badges are positioned correctly */
        }

        .custom-popup-wrapper {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.473);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .custom-popup-content {
            position: relative;
            width: 90%;
            max-width: 900px;
            background: #00000050;
            padding: 20px;
            border-radius: 5px;
        }
        
        .custom-popup-close {
            position: absolute;
            top: -20px;
            right: 10px;
            color: white;
            font-size: 40px;
            cursor: pointer;
            transition: 0.3s;
        }
        
        .custom-popup-close:hover {
            color: #0093D8;
        }
        
        /* Video Popup Styles */
        .custom-popup-video {
            width: 100%;
            height: 500px;
            border: none;
        }
        
        /* Slider Styles */
        .custom-slider-container {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
        }
        
        .custom-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .custom-slide.active {
            opacity: 1;
        }
        
        .custom-slide-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .custom-slider-prev,
        .custom-slider-next {
            align-items: center;
            appearance: none;
            background-color: #fff; /* Button-17 background */
            border-radius: 24px; /* Rounded corners from button-17 */
            border-style: none;
            box-shadow: rgba(0, 0, 0, .2) 0 3px 5px -1px, rgba(0, 0, 0, .14) 0 6px 10px 0, rgba(0, 0, 0, .12) 0 1px 18px 0;
            box-sizing: border-box;
            color: #3c4043; /* Button text color */
            cursor: pointer;
            display: inline-flex;
            font-family: "Google Sans", Roboto, Arial, sans-serif;
            font-size: 14px;
            font-weight: 600;
            height: 52px;
            justify-content: center;
            letter-spacing: .25px;
            line-height: normal;
            margin: 0;
            padding: 2px 24px; /* Adjusted padding */
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            text-transform: none;
            transition: box-shadow 280ms cubic-bezier(.4, 0, .2, 1), opacity 15ms linear 30ms, transform 270ms cubic-bezier(0, 0, .2, 1);
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            will-change: transform, opacity;
            z-index: 0;
        }

        .custom-slider-prev:hover,
        .custom-slider-next:hover {
            background: #F6F9FE; /* Button-17 hover background */
            color: #174ea6; /* Hover arrow color */
            box-shadow: rgba(60, 64, 67, .3) 0 2px 3px 0, rgba(60, 64, 67, .15) 0 6px 10px 4px;
        }

        .custom-slider-prev:active,
        .custom-slider-next:active {
            box-shadow: 0 4px 4px 0 rgb(60 64 67 / 30%), 0 8px 12px 6px rgb(60 64 67 / 15%);
            transform: translateY(2px); /* Pressed effect */
        }

        .custom-slider-prev:focus,
        .custom-slider-next:focus {
            border: 2px solid #4285f4; /* Focus outline */
        }

        .custom-slider-prev {
            left: 15px; /* Position for previous button */
        }

        .custom-slider-next {
            right: 15px; /* Position for next button */
        }

        @media (max-width: 768px) {
            .custom-popup-content {
                width: 95%;
                padding: 10px;
            }
            
            .custom-popup-video,
            .custom-slider-container {
                height: 300px;
            }
            
            .custom-popup-close {
                top: -25px;
                right: -5px;
                font-size: 30px;
            }
        }

        .testimonial-arrows > .slick-arrow{
            flex: 0 0 8.333333% !important;
            max-width: 8.333333% !important;
            transform: rotate(180deg) !important;
            margin-top: 0px !important;
        }
    </style>
@endsection

@section('befor-body-close')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.querySelector('.custom-popup-wrapper');
        const closeBtn = document.querySelector('.custom-popup-close');
        const triggers = document.querySelectorAll('.custom-popup-trigger');
        
        // Open popup
        triggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const isVideo = @json($isVideo);
                const content = @json($isVideo ? $home_text->video_section_url : $slides);
                
                if(isVideo) {
                    const iframe = popup.querySelector('.custom-popup-video');
                    const videoId = content.match(/(?:v=|\/)([a-zA-Z0-9_-]{11})/)[1];
                    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                } else {
                    initSlider(content);
                }
                
                popup.style.display = 'flex';
            });
        });
    
        // Close popup
        closeBtn.addEventListener('click', () => {
            popup.style.display = 'none';
            const iframe = popup.querySelector('.custom-popup-video');
            if(iframe) iframe.src = '';
        });
    
        // Close when clicking outside
        window.addEventListener('click', (e) => {
            if(e.target === popup) {
                popup.style.display = 'none';
                const iframe = popup.querySelector('.custom-popup-video');
                if(iframe) iframe.src = '';
            }
        });
    
        // Slider functionality
        function initSlider(images) {
            const slides = document.querySelectorAll('.custom-slide');
            let currentSlide = 0;
            
            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                slides[index].classList.add('active');
                currentSlide = index;
            }
    
            document.querySelector('.custom-slider-next').addEventListener('click', () => {
                const nextSlide = (currentSlide + 1) % slides.length;
                showSlide(nextSlide);
            });
    
            document.querySelector('.custom-slider-prev').addEventListener('click', () => {
                const prevSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(prevSlide);
            });
        }
    });
    </script>
@endsection