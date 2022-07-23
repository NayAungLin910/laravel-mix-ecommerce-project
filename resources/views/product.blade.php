@extends('layout.master')
@section('header-text', 'All Products')
@section('content')
    <div class="w-80 mt-5">

        <div class="row">

            <div class="col-12 col-sm-12 col-md-3 col-lg-3 ">
                <div class="card">
                    <div class="card-header bg-dark text-white">All Category</div>
                    @foreach ($category as $c)
                        <a href="{{ url('/products?category=' . $c->slug) }}">
                            <li class="list-group-item">
                                <img src="{{ $c->image }}" width="30" alt="">
                                <span class="text-dark">
                                    {{ app()->getLocale() === 'mm' ? $c->mm_name : $c->name }}
                                </span>
                                <small class="float-right badge badge-dark">{{ $c->product_count }}</small>
                            </li>
                        </a>
                    @endforeach
                </div>

                <div class="card">
                    <div class="card-header bg-dark text-white">All Brand</div>
                    @foreach ($brand as $b)
                        <a href="{{ url('/products?brand=' . $b->slug) }}">
                            <li class="list-group-item">
                                <span class="text-dark">
                                    {{ $b->name }}
                                </span>
                            </li>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card w-100 p-4">
                            <form action="">
                                <select name="category" class="btn btn-dark" id="">
                                    <option value="">Category</option>
                                    @foreach ($category as $c)
                                        <option value="{{ $c->slug }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <select name="color" class="btn  btn-dark" id="">
                                    <option value="">Color</option>
                                    @foreach ($color as $c)
                                        <option value="{{ $c->slug }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <select name="brand" class="btn  btn-dark" id="">
                                    <option value="">Brand</option>
                                    @foreach ($brand as $b)
                                        <option value="{{ $b->slug }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="btn  btn-white" placeholder="enter search" name="search"
                                    id="">
                                <input type="submit" class="btn  bg-primary" value="search" name="" id="">
                                <a href="{{ url('/products') }}" class="btn  btn-danger">Clear</a>
                            </form>
                        </div>
                    </div>


                    <!-- products -->
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-3 product">
                        <div class="row">
                            <!-- loop product -->
                            @foreach ($product as $p)
                                <div class="col-12 col-md-4 text-center mt-2">
                                    <a href="{{ url('/product/' . $p->slug) }}">
                                        <div class="card p-2">
                                            <img src="{{ $p->image }}" alt="" class="w-100">
                                            <b>{{ $p->name }}</b>
                                            <div>
                                                <small class=" badge badge-danger"> <strike>{{ $p->discount_price }}
                                                        Ks</strike> </small>
                                                <small class="badge bg-primary">{{ $p->sale_price }} Ks</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-3 product">
                        <nav aria-label="Page navigation ">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="#"> Pre </a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Nex</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
