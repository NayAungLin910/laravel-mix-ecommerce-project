@extends('admin.layout.master');
@section('content')
    <div>
        <a href={{ route('color.index') }} class="btn btn-dark">All Color</a>
    </div>
    <hr />
    <form action="{{ route('color.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="">Enter color</label>
            <input type="text" name="name" class="form-control">
        </div>
        <input type="submit" value="Create" class="btn btn-primary">
    </form>
@endsection
