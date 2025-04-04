@extends('user.layout')
@php
    $userDefaultLang = \App\Models\User\Language::where([['user_id', \Illuminate\Support\Facades\Auth::id()], ['is_default', 1]])->first();
    $userLanguages = \App\Models\User\Language::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
@endphp

@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Video Section') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Home Page') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Video Section') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-title">{{ __('Update Video Section') }}</div>
                        </div>

                    </div>
                </div>

                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form id="videoSecForm"
                                action="{{ route('user.home.page.update.video', ['language' => request()->input('language')]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <div class="col-12 mb-2">
                                        <label for="image"><strong>{{ __('Background Image') }} **</strong></label>
                                    </div>
                                    <div class="col-md-12 showImage mb-3">
                                        <img src="{{ isset($data->video_section_image) ? asset('assets/front/img/user/home_settings/' . $data->video_section_image) : asset('assets/admin/img/noimage.jpg') }}"
                                            alt="..." class="img-thumbnail">
                                    </div>
                                    <input type="file" name="video_section_image" id="image"
                                        class="form-control image">
                                    @if ($errors->has('video_section_image'))
                                        <div class="error text-danger">{{ $errors->first('video_section_image') }}
                                        </div>
                                    @endif
                                </div>

                                @if ($userBs->theme != 'home_ten' && $userBs->theme != 'home_five' && $userBs->theme != 'home_four')
                                    <div class="form-group">
                                        <label for="">{{ __('Video Section Title') }}</label>
                                        <input type="text" class="form-control" name="video_section_title"
                                            value="{{ $data->video_section_title ?? old('video_section_title') }}">
                                        @if ($errors->has('video_section_title'))
                                            <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_title') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                                @if ($userBs->theme != 'home_ten' && $userBs->theme != 'home_five' && $userBs->theme != 'home_four')

                                    @if ($userBs->theme != 'home_two')
                                        @if ($userBs->theme != 'home_seven')
                                            <div class="form-group">
                                                <label for="">{{ __('Video Section Subtitle') }}</label>
                                                <input type="text" class="form-control" name="video_section_subtitle"
                                                    value="{{ $data->video_section_subtitle ?? old('video_section_subtitle') }}">
                                                @if ($errors->has('video_section_subtitle'))
                                                    <p class="mt-2 mb-0 text-danger">
                                                        {{ $errors->first('video_section_subtitle') }}</p>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($userBs->theme != 'home_nine' && $userBs->theme != 'home_one')
                                            <div class="form-group">
                                                <label for="">{{ __('Video Section Text') }}</label>
                                                <textarea class="form-control" name="video_section_text" rows="3" cols="80">{{ $data->video_section_text ?? old('video_section_text') }}</textarea>
                                                @if ($errors->has('video_section_text'))
                                                    <p class="mt-2 mb-0 text-danger">
                                                        {{ $errors->first('video_section_text') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($userBs->theme != 'home_seven')
                                            <div class="form-group">
                                                <label for="">{{ __('Video Section Button Text') }}</label>
                                                <input type="text" class="form-control" name="video_section_button_text"
                                                    value="{{ $data->video_section_button_text ?? old('video_section_button_text') }}">
                                                @if ($errors->has('video_section_button_text'))
                                                    <p class="mt-2 mb-0 text-danger">
                                                        {{ $errors->first('video_section_button_text') }}</p>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($userBs->theme != 'home_seven')
                                            <div class="form-group">
                                                <label for="">{{ __('Video Section Button URL') }}</label>
                                                <input type="text" class="form-control" name="video_section_button_url"
                                                    value="{{ $data->video_section_button_url ?? old('video_section_button_url') }}">
                                                @if ($errors->has('video_section_button_url'))
                                                    <p class="mt-2 mb-0 text-danger">
                                                        {{ $errors->first('video_section_button_url') }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="form-group">
                                    <label for="">{{ __('Video URL') }}</label>
                                    <input type="text" class="form-control" name="video_section_url"
                                        value="{{ $data->video_section_url ?? old('video_section_url') }}"
                                        placeholder="Enter YouTube URL">
                                    @if ($errors->has('video_section_url'))
                                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_url') }}</p>
                                    @endif
                                
                                    <div class="col-12 mt-3">
                                        <label><strong>{{ __('OR Upload Slide Images') }}</strong></label>
                                        <p class="text-muted mb-2">{{ __('Upload images to replace video with slideshow') }}</p>
                                        
                                        {{-- Display existing slide images --}}
                                        <div class="row mb-3 existing-slides">
                                            @if(!empty($data->video_section_url) && isImage($data->video_section_url))
                                                @foreach(explode(',', $data->video_section_url) as $image)
                                                    @if(isImage($image))
                                                        <div class="col-md-3 mb-2 slide-image">
                                                            <img src="{{ asset('assets/front/img/user/video_slides/' . $image) }}" 
                                                                 class="img-thumbnail" style="width:100%; height:120px; object-fit:cover;">
                                                            <button type="button" class="btn btn-danger btn-sm remove-slide" 
                                                                    data-image="{{ $image }}" style="position:absolute; top:5px; right:5px;">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-12 text-muted">No slides currently added</div>
                                            @endif
                                        </div>
                                        
                                        <input type="file" name="video_section_slides[]" id="video_slides" 
                                               class="form-control" multiple accept="image/*">
                                    </div>
                                </div>
                                
                                @php
                                function isImage($str) {
                                    return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $str);
                                }
                                @endphp
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" form="videoSecForm" class="btn btn-success">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let removedSlides = [];
    
    // Handle slide removal
    $(document).on('click', '.remove-slide', function() {
        const imageName = $(this).data('image');
        removedSlides.push(imageName);
        $(this).closest('.slide-image').remove();
        
        // Update the hidden input for removed slides
        $('input[name="removed_slides"]').remove(); // Remove existing first
        $('<input>').attr({
            type: 'hidden',
            name: 'removed_slides',
            value: JSON.stringify(removedSlides)
        }).appendTo('form');
        
        // Get current video URL value
        let currentUrl = $('input[name="video_section_url"]').val();
        
        // If the current value contains images (comma-separated)
        if (currentUrl.includes(',')) {
            // Split into array
            let images = currentUrl.split(',');
            
            // Remove the deleted image
            images = images.filter(img => img.trim() !== imageName);
            
            // Update the input field
            $('input[name="video_section_url"]').val(images.join(','));
            
            // If no images left, clear the preview completely
            if (images.length === 0) {
                $('.existing-slides').html('');
            }
        } else if (currentUrl === imageName) {
            // If it was a single image, clear both field and preview
            $('input[name="video_section_url"]').val('');
            $('.existing-slides').html('');
        }
        
        // Show message if all images are removed
        if ($('.existing-slides').children().length === 0) {
            $('.existing-slides').html('<div class="col-12 text-muted">No slides currently added</div>');
        }
    });
    
    // Preview new slides before upload
    $('#video_slides').on('change', function() {
        $('.new-slides-container').remove();
        $('.existing-slides').append('<div class="col-12 mb-2 new-slides-container row"></div>');
        const files = this.files;
        
        // Remove "no slides" message if present
        $('.existing-slides .text-muted').remove();
        
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.new-slides-container').append(`
                    <div class="col-md-3 mb-2">
                        <img src="${e.target.result}" 
                             class="img-thumbnail" 
                             style="width:100%; height:120px; object-fit:cover;">
                    </div>
                `);
            }
            reader.readAsDataURL(files[i]);
        }
    });
});
</script>
@endsection