@extends('admin.layout.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection {
            height: 45px !important;
        }
    </style>
    <!--summer note css-->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endsection
@section('content')
    <div>
        <a href="{{ route('product.index') }}" class="btn btn-dark">All product</a>
    </div>
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-8">
                {{-- product info --}}
                <div class="card p-4">
                    <small class="text-muted">Product Information</small>
                    <div class="form-group">
                        <label for="">Enter product name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Choose product image</label>
                        <input type="file" name="image" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="">Enter description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>
                </div>
                {{-- product pricing --}}
                <div class="card p-4">
                    <small class="text-muted">Product Pricing</small>
                    <div class="form-group">
                        <label for="">Total Quantity</label>
                        <input type="number" name="total_quantity" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Buy Price</label>
                        <input type="number" name="buy_price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Sale Price</label>
                        <input type="number" name="sale_price" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="">Discounted Price</label>
                        <input type="number" name="discount_price" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card p-4">
                    <div class="form-group">
                        <label for="">Choose Supplier</label>
                        <select name="supplier_id" id="supplier" class="browser-default custom-select">
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Choose Category</label>
                        <select name="category_slug" id="category" class="browser-default custom-select">
                            @foreach ($category as $c)
                                <option value="{{ $c->slug }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Choose Brand</label>
                        <select name="brand_slug" id="brand" class="browser-default custom-select">
                            @foreach ($brand as $b)
                                <option value="{{ $b->slug }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Choose Color</label>
                        <select name="color_slug[]" id="color" class="browser-default custom-select" size='4'
                            multiple>
                            @foreach ($color as $c)
                                <option value="{{ $c->slug }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="submit" value="Create Product" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('#supplier').select2();
        })
    </script>
    <!--summer note script-->

    <script>
        $(function() {
            $('#description').summernote({
                callback: {
                    onImageUpload: function(files) {
                        var frmData = new FormData();
                        frmData.append('image', files[0]);
                        frmData.append('_token', '@php echo csrf_token(); @endphp')
                        $.ajax({
                            method: "POST",
                            url: "/admin/product-upload",
                            contentType: false,
                            processData: false,
                            data: frmData,
                            success: function(data) {
                                $('#description').summernote('insertImage', data);
                            }
                        })
                    }
                }
            })
        })
    </script>
@endsection
