@extends('user-front.layout')

@section('tab-title')
    {{ $product->name }} | {{ $keywords["Product_Details"] ?? "Product Details" }}
@endsection

@section('og-meta')
    <meta property="og:image" content="{{ asset('assets/front/img/user/products/'.$product->image) }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">
@endsection

@section('meta-description', $product->meta_description)
@section('meta-keywords', $product->meta_keywords)

@section('page-name')
    {{ $keywords["Product_Details"] ?? "Product Details" }}
@endsection

@section('br-name')
    {{ $keywords["Product_Details"] ?? "Product Details" }}
@endsection

@section('content')
    <!-- Product Details Section -->
    <section class="product-details section-gap">
        <div class="container">
            <div class="row">
                <!-- Main Product Content -->
                <div class="col-lg-8">
                    <div class="product-gallery mb-5">
                        <div class="main-image mb-4">
                            <img data-src="{{ asset('assets/front/img/user/products/'.$product->image) }}" 
                                 class="img-fluid rounded-lg lazy" 
                                 alt="{{ $product->name }}">
                        </div>
                    </div>
                    
                    <div class="product-content card border-0 shadow-sm">
                        <div class="card-body">
                            <h1 class="product-title mb-3">{{ $product->name }}</h1>
                            <div class="summernote-content">
                                {!! replaceBaseUrl($product->content) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="col-lg-4">
                    <div class="product-sidebar card border-0 shadow-sm">
                        <div class="card-body">
                    

                            <!-- Social Sharing -->
                            <div class="social-sharing card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3" style="text-align: center">
                                        <i class="fas fa-share-alt mr-2"></i>
                                        {{ $keywords["Share"] ?? "Share" }}
                                    </h6>
                                    <div class="social-links">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                           class="btn btn-social btn-facebook" 
                                           target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->name) }}&url={{ urlencode(url()->current()) }}" 
                                           class="btn btn-social btn-twitter" 
                                           target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($product->name) }}" 
                                           class="btn btn-social btn-linkedin" 
                                           target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Request Button -->
                            <button type="button" 
                                    class="btn btn-primary btn-block mb-4"
                                    data-toggle="modal" 
                                    data-target="#requestModal">
                                <i class="far fa-file-alt mr-2"></i>
                                {{ $keywords["Request_Product"] ?? "Request Product" }}
                            </button>
                            <p><small>We will contact you as soon as possible</small></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            @if($related_products->isNotEmpty())
            <div class="related-products mt-5">
                <h3 class="section-title mb-4">
                    {{ $keywords["Related_Products"] ?? "Related Products" }}
                </h3>
                <div class="row">
                    @foreach($related_products as $related)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="related-product card h-100 border-0 shadow-sm">
                            <a href="{{ route('front.user.q_products.detail', [getParam(), 'slug' => $related->slug, 'id' => $related->id]) }}" 
                               class="product-thumb">
                                <img data-src="{{ asset('assets/front/img/user/products/'.$related->image) }}" 
                                     class="card-img-top lazy" 
                                     alt="{{ $related->name }}">
                            </a>
                            <div class="card-body">
                                <h5 class="product-title">
                                    <a href="{{ route('front.user.q_products.detail', [getParam(), 'slug' => $related->slug, 'id' => $related->id]) }}">
                                        {{ Str::limit($related->name, 45) }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
    
    <!-- Request Modal (Keep existing functionality) -->
    <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true" style="margin-top: 5rem;">
        <div class="modal-dialog modal-lg" role="document"> <!-- Use modal-lg for a larger modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">{{ $keywords["Request_Product"] ?? "Request Product" }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="modal-form" action="{{ route('quote_products.req') }}" method="POST">
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
    
                        <!-- Row 3: Hidden Fields (if needed) -->
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                            </div>
                        </div>
    
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $keywords["Close"] ?? "Close" }}</button>
                            <button type="submit" class="btn btn-primary">{{ "Submit" }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .product-gallery img {
        max-height: 500px;
        object-fit: cover;
        width: 100%;
    }
    .social-links {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    .btn-social {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .related-product {
        transition: transform 0.3s ease;
    }
    .related-product:hover {
        transform: translateY(-5px);
    }
    .product-sidebar {
        position: sticky;
        top: 20px;
    }
</style>
@endsection