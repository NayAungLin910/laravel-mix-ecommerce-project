@extends('layout.master')
@section('header_text', 'Register')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-header bg-warning text-center text-white">Register</div>
                    <div class="card-body">
                        <form action="{{ url('/register') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Enter Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Enter Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Enter Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Choose Profile</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Enter Phone</label>
                                <input type="number" name="phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Enter Address</label>
                                <textarea name="address" class="form-control" cols="30" rows="5" ></textarea>
                            </div>
                            <input type="submit" value="Register" class="btn btn-warning">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
