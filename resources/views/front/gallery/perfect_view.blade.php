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
                    <button class="btn btn-outline-info" data-filter="*">Show All</button>
                    @foreach($p_name as $p)
                        <button class="btn btn-outline-info" data-filter=".p-{{ $p }}">{{ $p }}</button>
                    @endforeach
                    @foreach($s_name as $s)
                        <button class="btn btn-outline-info" data-filter=".s-{{ $s }}">{{ $s }}</button>
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
        
    
        // Initialize Isotope
        const $grid = new Isotope('.thumbnails-container', {
            itemSelector: '.thumbnail-item',
            layoutMode: 'fitRows', // Changed to fitRows for better compatibility
            transitionDuration: '0.4s'
        });
        console.log('Isotope initialized');
    
        let currentIndex = 0;
        let filteredItems = [];
        
        // Function to get visible items using Isotope's method
        function updateFilteredItems() {
            filteredItems = Array.from($grid.getFilteredItemElements());
            console.log('Current visible items:', filteredItems.map(item => item.dataset.index));
        }
    
        // Function to update main slide
        function updateMainSlide() {
            console.log(`Updating main slide. Current index: ${currentIndex}, Items count: ${filteredItems.length}`);
            
            if (filteredItems.length === 0) {
                console.log('No visible items - showing empty state');
                document.getElementById('mainSlideImage').style.display = 'none';
                document.querySelector('.no-images-message').style.display = 'block';
                return;
            }
            
            currentIndex = Math.max(0, Math.min(currentIndex, filteredItems.length - 1));
            const currentItem = filteredItems[currentIndex];
            console.log(`Setting main slide to item ${currentItem.dataset.index}`);
    
            const mainImage = document.getElementById('mainSlideImage');
            mainImage.style.display = 'block';
            mainImage.src = currentItem.dataset.src;
            mainImage.alt = currentItem.dataset.alt;
            document.querySelector('.no-images-message').style.display = 'none';
    
            // Update active thumbnail
            document.querySelectorAll('.thumbnail-item').forEach(item => item.classList.remove('active'));
            currentItem.classList.add('active');
    
            // Scroll into view
            currentItem.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    
        // Filter button click handler
        document.querySelectorAll('.filter-button-group button').forEach(button => {
            button.addEventListener('click', function() {
                const filterValue = this.getAttribute('data-filter');
                console.log(`Applying filter: ${filterValue}`);
                
                $grid.arrange({ filter: filterValue });
                
                $grid.once('arrangeComplete', function() {
                    console.log('Filtering complete');
                    updateFilteredItems();
                    currentIndex = 0;
                    updateMainSlide();
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
        }
    });
</script>
@endsection