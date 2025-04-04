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
                <!-- Filter buttons -->
                <div class="button-group filter-button-group" style="text-align: center; padding: 2rem;">
                    <button class="btn btn-info" data-filter="*">Show All</button>
                    @foreach($p_name as $p)
                        <button class="btn btn-info" data-filter=".p-{{ $p }}">{{ $p }}</button>
                    @endforeach
                    @foreach($s_name as $s)
                        <button class="btn btn-info" data-filter=".s-{{ $s }}">{{ $s }}</button>
                    @endforeach
                </div>

                <!-- Image grid -->
                <div class="grid">
                    @foreach($images as $image)
                        <div class="grid-item m-2 p-{{ $image->p_name }} s-{{ $image->s_name }}">
                            <img src="{{ asset('assets/user/img/galleries/' . $image->image) }}" 
                                 class="gallery-image" 
                                 alt="{{ $image->alt_text }}" 
                                 style="width:100%; max-width:300px; cursor: pointer;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
</div>

<script>
// Initialize Isotope
var $grid = $('.grid').isotope({
    itemSelector: '.grid-item',
    layoutMode: 'fitRows'
});

// Filter items on button click
$('.filter-button-group').on('click', 'button', function() {
    var filterValue = $(this).attr('data-filter');
    $grid.isotope({ filter: filterValue });
});

// Get the modal
var modal = document.getElementById("myModal");

// Get the modal image and caption elements
var modalImg = document.getElementById("modalImage");
var captionText = document.getElementById("caption");

// Get all gallery images
var galleryImages = document.querySelectorAll('.gallery-image');

// Loop through all gallery images and add click event listeners
galleryImages.forEach(function(img) {
    img.onclick = function() {
        modal.style.display = "block"; // Show the modal
        modalImg.src = this.src; // Set the modal image src to the clicked image src
        captionText.innerHTML = this.alt; // Set the caption to the clicked image alt text
    }
});

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none"; // Hide the modal
}

// When the user clicks anywhere outside the modal content, close the modal
modal.onclick = function(event) {
    if (event.target === modal) { // Check if the click is on the modal background
        modal.style.display = "none"; // Hide the modal
    }
}
</script>

<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 10001; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 600px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

.button-group button {
  background-color: #f1f1f1;
  border: none;
  color: black;
  padding: 10px 24px;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
@endsection

@section('befor-body-close')
<script src="https://cdnjs.cloudflare.com/ajax/libs/isotope/3.0.6/isotope.pkgd.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Isotope
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    // Automatically click "Show All" on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('button[data-filter="*"]').click();
    });

    // Filter items on button click
    $('.filter-button-group').on('click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
    });
});
</script>
@endsection