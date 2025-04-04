@extends('user-front.layout')

@section('og-meta')
    <!-- Custom Modal CSS -->
    <style>
        /* Custom Modal Styles */
        .custom-modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        }

        .custom-modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .custom-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .custom-modal-header .close {
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .custom-modal-header .close:hover {
            color: #000;
        }

        .custom-modal-body {
            margin-bottom: 20px;
        }

        .custom-modal-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: right;
        }

        .custom-modal-footer button {
            margin-left: 10px;
        }
    </style>
@endsection

@section('tab-title')
    {{ $keywords["Products"] ?? "Products" }}
@endsection

@section('meta-description', !empty($userSeo) ? $userSeo->services_meta_description : '')
@section('meta-keywords', !empty($userSeo) ? $userSeo->services_meta_keywords : '')

@section('page-name')
    {{ $keywords["Our_Products"] ?? "Our Products" }}
@endsection
@section('br-name')
    {{ $keywords["Products"] ?? "Products" }}
@endsection

@section('content')
    <section class="service-section service-line-shape mt-80 bg-white">
        <div class="container">
            <div class="section-title text-center both-border mb-50">
                <h4 class="title">{{ 'Our Products' }}</h4>
            </div>
            <!-- Products Boxes -->
            <div class="row service-boxes justify-content-center">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-sm-6">
                        <div class="single-product">
                            <div class="product-img">
                                <a class="d-block" 
                                @if($product->detail_page == 1)
                                href="{{ route('front.user.q_products.detail', [getParam(), 'slug' => $product->slug, 'id' => $product->id]) }}"
                                @endif>
                                    <img data-src="{{ isset($product->image) ? asset('assets/front/img/user/products/' . $product->image) : asset('assets/front/img/profile/service-1.jpg') }}" class="lazy" alt="">
                                </a>
                            </div>
                            <div class="product-desc" style="margin-top:5px;text-align: center;">
                                <h5 class="title">
                                    <a 
                                    @if($product->detail_page == 1)
                                    href="{{ route('front.user.q_products.detail', [getParam(), 'slug' => $product->slug, 'id' => $product->id]) }}"
                                    @endif>{{ $product->name }}</a>
                                </h5>
                                <!-- Button to trigger custom modal -->
                                <button type="button" class="btn btn-outline-info open-custom-modal" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" style="margin-top: 10px">
                                    {{ $keywords["Request_Product"] ?? "Request Product" }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--====== Client Area Start ======-->
            <div class="container">
                <!-- Section Title -->
                <div class="section-title text-center both-border mb-0" style="margin-top: 10rem">
                    <h4 class="title" style='font-size:2rem'>{{ 'Our Valueable Distributors' }}</h4>
                </div>
                <!-- Services Boxes -->
                <div class="client-slider mt-50 mb-50">
                    <div class="row align-items-center justify-content-between" id="clientSlider">
                        @foreach ($distributors as $brand)
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
            <!--====== Client Area End ======-->
        </div>
    </section>

    <!-- Custom Modal -->
    <div id="customModal" class="custom-modal" style="margin-top: 1rem">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 id="customModalTitle">{{ $keywords["Request_Product"] ?? "Request Product" }}</h5>
                <span class="close">&times;</span>
            </div>
            <div class="custom-modal-body">
                <form id="customModalForm" action="{{ route('quote_products.req') }}" method="POST">
                    @csrf
                    <!-- Row 1: Customer Name and Email -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name">{{ 'Customer Name' }}</label>
                                <input type="text" class="form-control" name="customer_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_email">{{ "Customer Email" }}</label>
                                <input type="email" class="form-control" name="customer_email" required>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Customer Phone and Message -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_phone">{{ "Customer Phone" }}</label>
                                <input type="text" class="form-control" name="customer_phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_note">{{ "Message(Optional)" }}</label>
                                <input type="text" class="form-control" name="customer_note">
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" id="productId" name="id">
                    <input type="hidden" id="productName" name="name">
                </form>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-danger">{{ $keywords["Close"] ?? "Close" }}</button>
                <button type="submit" form="customModalForm" class="btn btn-primary">{{ "Submit" }}</button>
            </div>
        </div>
    </div>
@endsection

@section('befor-body-close')
    <!-- Custom Modal JavaScript -->
    <script>
        // Get the modal
        const modal = document.getElementById('customModal');

        // Get the button that opens the modal
        const openModalButtons = document.querySelectorAll('.open-custom-modal');

        // Get the <span> element that closes the modal
        const closeModalButtons = document.querySelectorAll('.close');

        // Get the hidden input fields
        const productIdInput = document.getElementById('productId');
        const productNameInput = document.getElementById('productName');

        // Function to open the modal
        function openModal(productId, productName) {
            productIdInput.value = productId;
            productNameInput.value = productName;
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Add event listeners to open modal buttons
        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.getAttribute('data-product-id');
                const productName = button.getAttribute('data-product-name');
                openModal(productId, productName);
            });
        });

        // Add event listeners to close modal buttons
        closeModalButtons.forEach(button => {
            button.addEventListener('click', closeModal);
        });

        // Close the modal when clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
@endsection