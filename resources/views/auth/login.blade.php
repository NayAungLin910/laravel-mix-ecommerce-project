@extends('layout.master')
@section('header_text', 'Login')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-header bg-warning text-center text-white">Login</div>
                    <div class="card-body">
                        <form action="{{ url('/login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Enter Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Enter Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <input type="submit" value="Login" class="btn btn-warning">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
