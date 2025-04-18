@extends('user.layout')

@php
$selLang = \App\Models\User\Language::where([['code', \Illuminate\Support\Facades\Session::get('currentLangCode')], ['user_id', \Illuminate\Support\Facades\Auth::id()]])->first();
$userDefaultLang = \App\Models\User\Language::where([['user_id', \Illuminate\Support\Facades\Auth::id()], ['is_default', 1]])->first();
$userLanguages = \App\Models\User\Language::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
@endphp
@if (!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='userLanguage'] {
        direction: rtl;
    }

    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }

</style>
@endsection
@endif

@section('content')
<div class="page-header">
    <h4 class="page-title">{{ __('Products') }}</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('user.products_quote.index') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">{{ __('Product Page') }}</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">{{ __('Products') }}</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-title d-inline-block">{{ __('Products') }}</div>
                    </div>
                    <div class="col-lg-3">
                        @if (!is_null($userDefaultLang))
                        @if (!empty($userLanguages))
                        <select name="userLanguage" class="form-control" onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                            <option value="" selected disabled>{{ __('Select a Language') }}</option>
                            @foreach ($userLanguages as $lang)
                            <option value="{{ $lang->code }}" {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
                                {{ $lang->name }}</option>
                            @endforeach
                        </select>
                        @endif
                        @endif
                    </div>
                    <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                        @if (!is_null($userDefaultLang))
                        <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> {{ __('Add Product') }}</a>
                        <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{ route('user.products_quote.bulk.delete') }}"><i class="flaticon-interface-5"></i> {{ __('Delete') }}</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        @if (is_null($userDefaultLang))
                        <h3 class="text-center">{{ __('NO LANGUAGE FOUND') }}</h3>
                        @else
                        @if (count($products) == 0)
                        <h3 class="text-center">{{ __('NO PRODUCT FOUND') }}</h3>
                        @else
                        <div class="table-responsive">
                            <table class="table table-striped mt-3" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" class="bulk-check" data-val="all">
                                        </th>
                                        <th scope="col">{{ __('Image') }}</th>

                                        @if ($userBs->theme === 'home_six' || $userBs->theme === 'home_seven' || $userBs->theme === 'home_nine')
                                        <th scope="col">{{ __('Icon') }}</th>
                                        @endif
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Language') }}</th>
                                        @if ($userBs->theme == 'home_ten' || $userBs->theme == 'home_eleven')
                                        @else
                                        <th scope="col">{{ __('Featured') }}</th>
                                        @endif
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="bulk-check" data-val="{{ $product->id }}">
                                        </td>
                                        <td>
                                            <img src="{{ asset('assets/front/img/user/products/' . $product->image) }}" alt="" width="80">
                                        </td>
                                        @if ($userBs->theme === 'home_six' || $userBs->theme === 'home_seven' || $userBs->theme === 'home_nine')
                                        <td>
                                            <i class="{{ $product->icon }}"></i>
                                        </td>
                                        @endif
                                        <td>{{ strlen($product->name) > 30 ? mb_substr($product->name, 0, 30, 'UTF-8') . '...' : $product->name }}
                                        </td>
                                        <td>{{ $product->language->name }}</td>
                                        @if ($userBs->theme == 'home_ten' || $userBs->theme == 'home_eleven')
                                        @else
                                        <td>
                                            <form id="featureForm{{ $product->id }}" class="d-inline-block" action="{{ route('user.products_quote.feature') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{ $product->id }}">
                                                <select class="form-control {{ $product->featured == 1 ? 'bg-success' : 'bg-danger' }}" name="featured" onchange="document.getElementById('featureForm{{ $product->id }}').submit();">
                                                    <option value="1" {{ $product->featured == 1 ? 'selected' : '' }}>
                                                        {{ __('Yes') }}
                                                    </option>
                                                    <option value="0" {{ $product->featured == 0 ? 'selected' : '' }}>
                                                        {{ __('No') }}
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        @endif
                                        <td>
                                            <a class="btn btn-secondary btn-sm" href="{{ route('user.products_quote.edit', $product->id) . '?language=' . $product->language->code }}">
                                                <span class="btn-label">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                {{ __('Edit') }}
                                            </a>
                                            <form class="deleteform d-inline-block" action="{{ route('user.products_quote.delete') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                    <span class="btn-label">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-title d-inline-block">{{ __('Orders Quote List') }}</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped mt-3" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Customer Name') }}</th>
                                        <th scope="col">{{ __('Customer Email') }}</th>
                                        <th scope="col">{{ __('Customer Phone') }}</th>
                                        <th scope="col">{{ __('Product Name') }}</th>
                                        <th scope="col">{{ __('Message') }}</th>
                                        <th scope="col">{{ __('Approval Status') }}</th>
                                        <th scope="col">{{ __('Date and Time') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_email }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>{{ $order->product_name }}</td>
                                        <td>{{ $order->customer_note }}</td>
                                        <td>
                                            <form id="approveForm{{ $order->id }}" class="d-inline-block" action="{{ route('user.products_quote.approve') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $order->id }}">
                                                <select class="form-control {{ $order->approved == 1 ? 'bg-success' : 'bg-danger' }}" name="approved" onchange="document.getElementById('approveForm{{ $order->id }}').submit();">
                                                    <option value="1" {{ $order->approved == 1 ? 'selected' : '' }}>
                                                        {{ __('Read') }}
                                                    </option>
                                                    <option value="0" {{ $order->approved == 0 ? 'selected' : '' }}>
                                                        {{ __('Unread') }}
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Blog Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Product') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxForm" enctype="multipart/form-data" class="modal-form" action="{{ route('user.products_quote.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-12 mb-2">
                                    <label for="image"><strong>{{ __('Image') }}*</strong></label>
                                </div>
                                <div class="col-md-12 showImage mb-3">
                                    <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..." class="img-thumbnail">
                                </div>
                                <input type="file" name="image" id="image" class="form-control">
                                <p id="errimage" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('Language') }} **</label>
                        <select name="user_language_id" class="form-control">
                            <option value="" selected disabled>{{ __('Select a language') }}</option>
                            @foreach ($userLanguages as $lang)
                            <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                            @endforeach
                        </select>
                        <p id="erruser_language_id" class="mb-0 text-danger em"></p>
                    </div>
                    @if ($userBs->theme === 'home_six' || $userBs->theme === 'home_seven' || $userBs->theme === 'home_nine')
                    <div class="form-group">
                        <label for="">{{ __('Product Icon') }} **</label>
                        <div class="btn-group d-block">
                            <button type="button" class="btn btn-primary iconpicker-component"><i class="fa fa-fw fa-heart"></i></button>
                            <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-car" data-toggle="dropdown">
                            </button>
                            <div class="dropdown-menu"></div>
                        </div>
                        <input id="inputIcon" type="hidden" name="icon" value="">
                        @if ($errors->has('icon'))
                        <p class="mb-0 text-danger">{{ $errors->first('icon') }}</p>
                        @endif
                        <div class="text-warning mt-2">
                            <small>{{ __('NB: click on the dropdown icon to select a product icon.') }}</small>
                        </div>
                        <p id="erricon" class="mb-0 text-danger em"></p>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="">{{ __('Name') }} **</label>
                        <input type="text" class="form-control" name="name" value="">
                        <p id="errname" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('Content') }}</label>
                        <textarea class="form-control summernote" name="content" rows="8" cols="80"></textarea>
                        <p id="errcontent" class="mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Serial Number') }} **</label>
                        <input type="number" class="form-control ltr" name="serial_number" value="">
                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                        <p class="text-warning mb-0">
                            <small>{{ __('The higher the serial number is, the later the product will be shown.') }}</small>
                        </p>
                    </div>
                    @if (
                    $userBs->theme != 'home_nine' ||
                    $userBs->theme != 'home_ten' ||
                    $userBs->theme != 'home_eleven' ||
                    $userBs->theme != 'home_twelve')
                    @else
                    <div class="form-group">
                        <label for="featured" class="my-label mr-3">{{ __('Featured') }}</label>
                        <input id="featured" type="checkbox" name="featured" value="1">
                        <p id="errfeatured" class="mb-0 text-danger em"></p>
                    </div>
                    @endif
                    <div class="form-group">
                        <div class="d-flex">
                            <label class="mr-3">{{ __('Detail Page') }}</label>
                            <div class="radio mr-3">
                                <label><input type="radio" name="detail_page" value="1" checked class="mr-1">{{ __('Enable') }}</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="detail_page" value="0" class="mr-1">{{ __('Disable') }}</label>
                            </div>
                        </div>
                        <p id="errdetail_page" class="mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Meta Keywords') }}</label>
                        <input type="text" class="form-control" name="meta_keywords" value="" data-role="tagsinput">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('Meta Description') }}</label>
                        <textarea type="text" class="form-control" name="meta_description" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button id="submitBtn" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
