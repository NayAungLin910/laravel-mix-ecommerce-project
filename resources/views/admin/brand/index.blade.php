@extends('admin.layout.master')
@section('content')
    <div>
        <a href="{{ route('brand.create') }}" class="btn btn-success">Create brand</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brand as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>
                        <a href="{{ route('brand.edit', $c->slug) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('brand.destroy', $c->slug) }}" method="POST" class="d-inline"
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
    {{ $brand->links() }}
@endsection
