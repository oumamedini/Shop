@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Generate New Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Generate New Product</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <form action="{{ route('admin.openai.generate') }}" method="POST" id="generateForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" id="categorySelect" class="form-control" required>
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keywords</label>
                                <textarea name="keywords" id="keywordsInput" class="form-control" placeholder="Enter product keywords (e.g., modern, comfortable, durable)" required></textarea>
                                <small class="form-text text-muted">Separate keywords with commas for better results</small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-magic"></i> Generate Product
                    </button>
                </form>

                <div id="result" class="mt-4" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Generated Product</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="productData"></div>
                                </div>
                                <div class="col-md-4">
                                    <div id="imageContainer" class="text-center mb-3" style="display: none;">
                                        <img id="generatedImage" src="" alt="Generated Product Image" class="img-fluid rounded">
                                        <div class="mt-2">
                                            <button id="regenerateImage" class="btn btn-info btn-sm">
                                                <i class="fas fa-sync"></i> Regenerate Image
                                            </button>
                                        </div>
                                    </div>
                                    <div id="imageLoading" style="display: none;">
                                        <div class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Generating image...</span>
                                            </div>
                                            <p class="mt-2">Generating product image...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button id="saveProduct" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Product
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let currentProduct = null;
    let currentImagePath = null;

    function generateImage(productName) {
        $('#imageContainer').hide();
        $('#imageLoading').show();

        $.ajax({
            url: "{{ route('admin.openai.image') }}",
            method: 'POST',
            data: {
                prompt: `Professional product photo of ${productName}, white background, high quality, commercial style`
            },
            success: function(response) {
                if (response.success) {
                    currentImagePath = response.filename;
                    // Use the full URL provided by the server
                    $('#generatedImage').attr('src', response.url);
                    $('#imageContainer').show();
                } else {
                    alert('Error generating image: ' + response.error);
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Failed to generate image'));
            },
            complete: function() {
                $('#imageLoading').hide();
            }
        });
    }

    $('#generateForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    currentProduct = response.product;
                    $('#productData').html(`
                        <div class="form-group">
                            <label class="font-weight-bold">Name:</label>
                            <p class="lead">${currentProduct.name}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Description:</label>
                            <p>${currentProduct.description}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Price:</label>
                            <p class="h4">$${currentProduct.price.toFixed(2)}</p>
                        </div>
                    `);
                    $('#result').show();
                    
                    // Generate image for the product
                    generateImage(currentProduct.name);
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Failed to generate product'));
            }
        });
    });

    $('#regenerateImage').on('click', function() {
        if (currentProduct) {
            generateImage(currentProduct.name);
        }
    });

    $('#saveProduct').on('click', function() {
        if (!currentProduct || !currentImagePath) {
            alert('Please wait for both product and image generation to complete.');
            return;
        }

        const productData = {
            category_id: $('#categorySelect').val(),
            name: currentProduct.name,
            description: currentProduct.description,
            price: currentProduct.price,
            image: currentImagePath
        };

        $.ajax({
            url: "{{ route('admin.openai.store') }}",
            method: 'POST',
            data: productData,
            success: function(response) {
                if (response.success) {
                    alert('Product saved successfully!');
                    window.location.href = "{{ route('admin.products.index') }}";
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Failed to save product'));
            }
        });
    });
});
</script>
@endpush
@endsection
