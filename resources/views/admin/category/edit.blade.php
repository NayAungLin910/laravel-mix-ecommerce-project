@extends('admin.layout.master');
@section('content')
    <div>
        <a href={{ route('category.index') }} class="btn btn-dark">All Category</a>
    </div>
    <hr />
    <form action="{{ route('category.update', $category->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Enter Category</label>
            <input type="text" value="{{ $category->name }}" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Enter Name(MM)</label>
            <input type="text" name="mm_name" value="{{ $category->mm_name }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Choose new image</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ $category->image }}" width="100" class="img-thumbnail" alt="">
        </div>
        <input type="submit" value="Update" class="btn btn-primary">
    </form>
@endsection
