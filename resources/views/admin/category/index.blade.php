@extends('admin.layout.master')
@section('content')
    <div>
        <a href="{{ route('category.create') }}" class="btn btn-success">Create category</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Name(MM)</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($category as $c)
                <tr>
                    <td>
                        <img src="{{ $c->image }}" width="75" alt="">
                    </td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->mm_name }}</td>
                    <td>
                        <a href="{{ route('category.edit', $c->slug) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('category.destroy', $c->slug) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure of deleting?')">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $category->links() }}
@endsection
