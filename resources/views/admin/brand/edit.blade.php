@extends('admin.layout.master');
@section('content')
    <div>
        <a href={{ route('brand.index') }} class="btn btn-dark">All Brands</a>
    </div>
    <hr />
    <form action="{{ route('brand.update', $brand->slug) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Enter brand</label>
            <input type="text" value="{{ $brand->name }}" name="name" class="form-control">
        </div>
        <input type="submit" value="Update" class="btn btn-primary">
    </form>
@endsection
