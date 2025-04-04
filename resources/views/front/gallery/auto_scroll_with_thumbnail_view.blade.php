@extends('user-front.layout')
@section('og-meta')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/isotope/3.0.6/isotope.min.css">
@endsection
@section('tab-title')
    {{ 'Gallery' }}
@endsection
@php
    Config::set('app.timezone', $userBs->timezoneinfo->timezone ?? '');
@endphp
@section('meta-description', !empty($userSeo) ? $userSeo->home_meta_description : '')
@section('meta-keywords', !empty($userSeo) ? $userSeo->home_meta_keywords : '')
@section('page-name')
    {{ $keywords['Gallery'] ?? 'Gallery' }}
@endsection
@section('br-name')
    {{ $keywords['Gallery'] ?? 'Gallery' }}
@endsection
@section('content')
@php
  $p_name = $images->unique('p_name')->pluck('p_name');
  $s_name = $images->unique('s_name')->pluck('s_name');
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="button-group filter-button-group" style="text-align: center; padding: 2rem;">
                    <div class="filter-button-wrapper">
                        <button class="btn btn-outline-info" data-filter="*">Show All</button>
                        <div class="filter-preview">
                            <img src="" alt="Preview">
                        </div>
                    </div>
                    @foreach($p_name as $p)
                        <div class="filter-button-wrapper">
                            <button class="btn btn-outline-info" data-filter=".p-{{ $p }}" 
                                    data-preview-src="{{ $images->where('p_name', $p)->first()->image ?? '' }}">
                                {{ $p }}
                            </button>
                            <div class="filter-preview">
                                <img src="{{ asset('assets/user/img/galleries/' . ($images->where('p_name', $p)->first()->image ?? '')) }}" 
                                     alt="{{ $p }} preview">
                            </div>
                        </div>
                    @endforeach
                    @foreach($s_name as $s)
                        <div class="filter-button-wrapper">
                            <button class="btn btn-outline-info" data-filter=".s-{{ $s }}"
                                    data-preview-src="{{ $images->where('s_name', $s)->first()->image ?? '' }}">
                                {{ $s }}
                            </button>
                            <div class="filter-preview">
                                <img src="{{ asset('assets/user/img/galleries/' . ($images->where('s_name', $s)->first()->image ?? '')) }}" 
                                     alt="{{ $s }} preview">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="gallery-slideshow-container">
                    <div class="main-slide">
                        <div class="slider-nav-button slider-prev">❮</div>
                        <div class="slider-nav-button slider-next">❯</div>
                        <img src="" class="main-slide-image" alt="" id="mainSlideImage">
                        <div class="no-images-message" style="display: none;">No images found in this category</div>
                    </div>

                    <div class="thumbnails-container isotope">
                        @foreach($images as $index => $image)
                            <div class="thumbnail-item grid-item p-{{ $image->p_name }} s-{{ $image->s_name }}"
                                 data-index="{{ $index }}"
                                 data-src="{{ asset('assets/user/img/galleries/' . $image->image) }}"
                                 data-alt="{{ $image->alt_text }}">
                                <img src="{{ asset('assets/user/img/galleries/' . $image->image) }}" 
                                     class="thumbnail-image" 
                                     alt="{{ $image->alt_text }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-slideshow-container {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.main-slide {
    position: relative;
    width: 100%;
    height: 500px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
}

.main-slide-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: opacity 0.3s ease;
}

.thumbnails-container {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 10px 0;
    min-height: 100px;
}

.thumbnail-item {
    flex: 0 0 120px;
    cursor: pointer;
    opacity: 0.6;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.thumbnail-item.active {
    opacity: 1;
    border-color: #007bff;
}

.thumbnail-image {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.slider-nav-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 15px;
    cursor: pointer;
    font-size: 24px;
    z-index: 10;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider-nav-button:hover {
    background: rgba(0,0,0,0.8);
}

.slider-prev {
    left: 20px;
}

.slider-next {
    right: 20px;
}

.no-images-message {
    text-align: center;
    padding: 50px;
    font-size: 1.2em;
    color: #666;
    width: 100%;
}

/* Hide arrows when only one image */
.thumbnails-container:only-child .slider-nav-button {
    display: none;
}
.filter-preview {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: 150px;
    height: 150px;
    background-color: white;
    border: 2px solid #007bff;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 100;
    display: none;
    overflow: hidden;
}

.filter-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.filter-button-wrapper {
    position: relative;
    display: inline-block;
    margin: 0 5px;
}

.filter-button-group {
    position: relative;
    min-height: 50px; /* Ensure space for preview */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-slide {
        height: 300px;
    }
    
    .slider-nav-button {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .thumbnail-item {
        flex: 0 0 80px;
    }
    
    .thumbnail-image {
        height: 60px;
    }
}
</style>

    
@endsection

@section('befor-body-close')
<script src="https://cdnjs.cloudflare.com/ajax/libs/isotope/3.0.6/isotope.pkgd.min.js"></script>
<script>
    console.log('DOM fully loaded - initializing gallery');
    document.addEventListener('DOMContentLoaded', function() {
        
        const $grid = new Isotope('.thumbnails-container', {
            itemSelector: '.thumbnail-item',
            layoutMode: 'fitRows',
            transitionDuration: '0.4s'
        });

        let currentIndex = 0;
        let filteredItems = [];
        let autoSlideInterval;

        // Function to start/reset auto-slide
        function startAutoSlide() {
            clearInterval(autoSlideInterval);
            if (filteredItems.length > 1) {
                autoSlideInterval = setInterval(() => {
                    currentIndex = (currentIndex + 1) % filteredItems.length;
                    updateMainSlide();
                }, 3000); // Change slide every 3 seconds
            }
        }

        function updateFilteredItems() {
            filteredItems = Array.from($grid.getFilteredItemElements());
        }

        function updateMainSlide() {
            if (filteredItems.length === 0) {
                document.getElementById('mainSlideImage').style.display = 'none';
                document.querySelector('.no-images-message').style.display = 'block';
                return;
            }

            currentIndex = Math.max(0, Math.min(currentIndex, filteredItems.length - 1));
            const currentItem = filteredItems[currentIndex];

            const mainImage = document.getElementById('mainSlideImage');
            mainImage.style.display = 'block';
            mainImage.src = currentItem.dataset.src;
            mainImage.alt = currentItem.dataset.alt;
            document.querySelector('.no-images-message').style.display = 'none';

            document.querySelectorAll('.thumbnail-item').forEach(item => item.classList.remove('active'));
            currentItem.classList.add('active');
            currentItem.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

            // Restart auto-slide timer
            startAutoSlide();
        }

        // Filter button click handler
        document.querySelectorAll('.filter-button-group button').forEach(button => {
            button.addEventListener('click', function() {
                const filterValue = this.getAttribute('data-filter');
                $grid.arrange({ filter: filterValue });
                
                $grid.once('arrangeComplete', function() {
                    updateFilteredItems();
                    currentIndex = 0;
                    updateMainSlide();
                    startAutoSlide();
                });
            });
        });

        // Navigation buttons
        document.querySelector('.slider-prev').addEventListener('click', () => {
            if (filteredItems.length <= 1) return;
            currentIndex = (currentIndex - 1 + filteredItems.length) % filteredItems.length;
            updateMainSlide();
        });

        document.querySelector('.slider-next').addEventListener('click', () => {
            if (filteredItems.length <= 1) return;
            currentIndex = (currentIndex + 1) % filteredItems.length;
            updateMainSlide();
        });

        // Thumbnail click handler
        document.querySelector('.thumbnails-container').addEventListener('click', (e) => {
            const thumbnail = e.target.closest('.thumbnail-item');
            if (!thumbnail) return;
            
            const index = filteredItems.indexOf(thumbnail);
            if (index !== -1) {
                currentIndex = index;
                updateMainSlide();
            }
        });

        // Initial setup
        updateFilteredItems();
        if (filteredItems.length > 0) {
            updateMainSlide();
            startAutoSlide();
        }

        document.querySelectorAll('.filter-button-wrapper').forEach(wrapper => {
            const button = wrapper.querySelector('button');
            const preview = wrapper.querySelector('.filter-preview');
            const previewImg = preview.querySelector('img');
            
            // Get the first image for this filter
            const filterValue = button.getAttribute('data-filter');
            const firstItem = document.querySelector(`${filterValue}`);
            if (firstItem) {
                previewImg.src = firstItem.dataset.src;
            }

            button.addEventListener('mouseenter', () => {
                // Position the preview
                preview.style.display = 'block';
                
                // If no image found, show a message
                if (!previewImg.src || previewImg.src.includes('undefined')) {
                    preview.innerHTML = '<div style="padding: 10px; text-align: center;">No preview available</div>';
                }
            });

            button.addEventListener('mouseleave', () => {
                preview.style.display = 'none';
                // Restore image if we replaced it with message
                if (preview.innerHTML.includes('No preview')) {
                    preview.innerHTML = '<img src="" alt="Preview">';
                    previewImg.src = firstItem ? firstItem.dataset.src : '';
                }
            });
        });
    
        // Initial setup
        updateFilteredItems();
        if (filteredItems.length > 0) {
            updateMainSlide();
        }
    });
</script>

<script>
    let slideIndex = 0;
    showSlides();
    
    function showSlides() {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
      setTimeout(showSlides, 2000); // Change image every 2 seconds
    }
    </script>
@endsection