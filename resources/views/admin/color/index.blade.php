@extends('admin.layout.master')
@section('content')
    <div>
        <a href="{{ route('color.create') }}" class="btn btn-success">Create color</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($color as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>
                        <a href="{{ route('color.edit', $c->slug) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('color.destroy', $c->slug) }}" method="POST" class="d-inline"
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
    {{ $color->links() }}
@endsection
