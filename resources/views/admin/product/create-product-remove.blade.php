@extends('admin.layout.master')
@section('content')
    <h2>
        <b class="text-danger">Remove</b> quantity of 
        <b class="text-primary">{{ $product->name }}</b>
    </h2>
    <div>
        <a href="{{ route('product.index') }}" class="btn btn-dark">
            All product
        </a>
    </div>
    <form class="mt-3" action="{{ url("admin/create-product-remove/" . $product->slug) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="">Enter total quantity</label>
            <input type="number" class="form-control" name="total_quantity">
        </div>
        <div class="form-group">
            <label for="">Enter Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <input type="submit" value="Remove" class="btn btn-primary">
    </form>
@endsection
