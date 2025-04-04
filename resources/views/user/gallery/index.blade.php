@extends('user.layout')

@section('content')
<div class="page-header">
    <h4 class="page-title">Gallery</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('user-dashboard') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Gallery and Files Management</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Upload New Image/pdf</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('user.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Image/file</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <div class="avoid-for-pdf" style="border: 1px dotted red; padding-top: 10px;">
                        <div class="form-group">
                            <h5><strong>Avoid using these two for PDF. Only use for images</strong></h5>
                        </div>
                        <div class="form-group">
                            <!-- Service Name Dropdown with Free Text -->
                            <label for="s_name">Service Name:</label>
                            <input list="s_name_list" name="s_name" id="s_name" placeholder="Type or select a service">
                            <datalist id="s_name_list">
                                @foreach($s_name as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-group">
                            <!-- Place/Project Name Dropdown with Free Text -->
                            <label for="p_name">Place Name:</label>
                            <input list="p_name_list" name="p_name" id="p_name" placeholder="Type or select a place">
                            <datalist id="p_name_list">
                                @foreach($p_name as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Alt Text for Image and Title for PDF</label>
                        <input type="text" name="alt_text" class="form-control" placeholder="Enter alt text">
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Your Gallery Images</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($images as $image)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="{{ asset('assets/user/img/galleries/' . $image->image) }}" class="card-img-top" alt="{{ $image->alt_text }}">
                            <div class="card-body">
                                <form action="{{ route('user.gallery.destroy', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $images->links() }}
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Your PDFs</h4>
            </div>
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
                            <div class="card-body">
                                <p>{{ $file->created_at->format('d M, Y') }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.gallery.destroy', $file->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $pdf->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
