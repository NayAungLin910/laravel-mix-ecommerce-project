@extends('admin.layout.master')
@section('css')
    <style>
        .cus-con {
            background: rgb(131, 58, 180);
            background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 50%, rgba(252, 176, 69, 1) 100%);
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-3 p-3">
            <div class="container p-3 rounded cus-con">
                <h3 class="text-white text-center">Today Income</h3>
                <h2 class="text-white text-center">{{ $todayIncomeCount }} ks</h2>
            </div>
        </div>
        <div class="col-sm-3 p-3">
            <div class="container p-3 rounded cus-con">
                <h3 class="text-white text-center">Today Outcome</h3>
                <h2 class="text-white text-center">{{ $todayOutcomeCount }} ks</h2>
            </div>
        </div>
        <div class="col-sm-3 p-3">
            <div class="container p-3 pl-6 pb-4 rounded cus-con">
                <table>
                    <tbody>
                        <tr>
                            <td><i class="fa-solid fa-user-large text-white" style="font-size: 30px"></i></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h3 class="text-white">Users</h3>
                                <span class="text-white">{{ $userCount }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-3 p-3">
            <div class="container p-3 pl-6 pb-4 rounded cus-con">
                <table>
                    <tbody>
                        <tr>
                            <td><i class="fa-solid fa-heart text-white" style="font-size: 30px"></i></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="h4 text-white">Total products</span>
                                <span class="text-white">{{ $productCount }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>အရောင်းအချက်အလက်</h4>
                    <canvas id="saleChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>ဝင်ငွေထွက်ငွေ</h4>
                    <canvas id="inoutChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Latest User List</h4>
                    <ul class="list-group">
                        @foreach ($latestusers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <img src="{{ $user->image }}" alt="{{ $user->name }}" width="50"
                                    class="rounded-circle">
                                <span>{{ $user->email }}</span>
                                <span class="badge badge-warning">{{ $user->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Product with low stock</h4>
                    <table class="table border table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $p)
                                <tr>
                                    <td><img src="{{ $p->image }}" width="70" class="rounded-circle"></td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->total_quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($revMonths);

        const data = {
            labels: labels,
            datasets: [{
                label: 'အရောင်းအချက်အလက်',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: @json($revSaleData),
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        new Chart(
            document.getElementById('saleChart'),
            config
        );

        // income outcome chart
        const inoutLabels = @json($revDayMonths);

        const inoutData = {
            labels: inoutLabels,
            datasets: [{
                label: 'ဝင်ငွေ',
                backgroundColor: 'green',
                borderColor: 'green',
                data: @json($revIncomeCount),
            }, {
                label: 'ထွက်ငွေ',
                backgroundColor: 'red',
                borderColor: 'red',
                data: @json($revOutcomeCount),
            }]
        };

        const inoutConfig = {
            type: 'line',
            data: inoutData,
            options: {}
        };

        new Chart(
            document.getElementById('inoutChart'),
            inoutConfig
        );
    </script>
@endsection
