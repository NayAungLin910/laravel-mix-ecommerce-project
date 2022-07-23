@extends('admin.layout.master')
@section('content')
    <div>
        <a href="{{ route('product.create') }}" class="btn btn-success">Create product</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Remaining Quantity</th>
                <th>Add or Remove</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
                <tr>
                    <td><img src="{{ $p->image }}" width="100" alt=""></td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->total_quantity }}</td>
                    <td>
                        <a href="{{ url('admin/create-product-remove/' . $p->slug) }}" class="btn btn-warning">-</a>
                        <a href="{{ url('admin/create-product-add/' . $p->slug) }}" class="btn btn-success">+</a>
                    </td>
                    <td>
                        <a href="{{ route('product.edit', $p->slug) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('product.destroy', $p->slug) }}" method="POST" class="d-inline"
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
    {{ $products->links() }}
@endsection
