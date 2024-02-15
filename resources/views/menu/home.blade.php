<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

@extends('layouts.app')

@section('container')
    <style>
        .alert {
            margin-right: 10px;
        }

        .container {
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f1f1;
        }

        .card-body {
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-md-6 {
            width: 50%;
            padding: 10px;
            text-align: center;

        }

        .col-md-6 i {
            margin-top: 10px;
        }

        .circle-icon {
            margin-left: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            /* background-color: #3498db;
                                                                                                                color: #fff; */
        }
    </style>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible d-flex align-items-center fade show">
            <i class="bi-check-circle-fill"></i>
            <strong class="mx-2">Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show">
            <i class="bi-exclamation-octagon-fill"></i>
            <strong class="mx-2">Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h2 class="ml-3 text-xl font-bold text-gray-900">Dashboard</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="" class="card bg-warning hoverable card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body">
                        <i class="fa-solid fa-user-secret fa-2xl text-center mt-3" style="color: black"></i>

                        <div class="text-white fw-bold fs-5 mb-2 mt-4 ">
                            Admin
                        </div>
                        <div class="fw-semibold text-white ">
                            {{ $admin }}
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-md-3">
                <a href="" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body">
                        <i class="fas fa-users fa-xl mt-3" style="color: white"></i>

                        <div class="text-white fw-bold fs-5 mb-2 mt-4 ">
                            Customers
                        </div>
                        <div class="fw-semibold text-white ">
                            {{ $user }}
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-md-3">
                <a href="" class="card bg-success hoverable card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body">
                        <i class="fas fa-envelope fa-2xl mt-3" style="color: white"></i>
                        <div class="text-white fw-bold fs-5 mb-2 mt-4 ">
                            Pesan Masuk
                        </div>
                        <div class="fw-semibold text-white ">
                            {{ $contact }}
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-md-3">
                <a href="" class="card hoverable card-xl-stretch mb-5 mb-xl-8" style="background-color: #15acc5">
                    <div class="card-body">
                        <i class="fa-solid fa-flask fa-2xl mt-3" style="color: white"></i>

                        <div class="text-white fw-bold fs-5 mb-2 mt-4 ">
                            Product
                        </div>
                        <div class="fw-semibold text-white ">
                            {{ $product }}
                        </div>
                    </div>

                </a>
            </div>
        </div>
    </div>


    <div class="container" style="width: 100%;">
        <h2 class="ml-3 text-xl font-bold text-gray-900">Statistik User</h2>
        <div class="d-flex justify-content-end my-2">
            <div class="me-2">
                <label for="bulan">Pilih Bulan:</label>
                <select id="bulan" name="bulan" class="form-control">
                    <option selected disabled>Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="me-2">
                <label for="tahun">Pilih Tahun:</label>
                <select id="tahun" name="tahun" class="form-control">
                    <option selected disabled>Pilih Tahun</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <div class="me-2 mt-4">
                <button type="submit" class="btn btn-primary" id="filter"
                    style="background-color: #002c4f;border: none">Filter</button>
                <a class="btn btn-success" id="downloadExcel" href="{{ route('downloadExcel') }}"
                    style="background-color: green;border: none"><i class="bi bi-file-earmark-excel-fill"
                        style="font-size: 1.5rem"></i></a>
            </div>
        </div>
        <canvas id="userChart"></canvas>
    </div>

    <div class="container" style="width: 100%;">
        <h2 class="ml-3 text-xl font-bold text-gray-900">Statistik Penjualan Product</h2>
        <div class="d-flex justify-content-end my-2">
            <div class="me-2">
                <label for="bulan">Pilih Bulan:</label>
                <select id="bulanProduct" name="bulanProduct" class="form-control">
                    <option selected disabled>Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="me-2">
                <label for="tahun">Pilih Tahun:</label>
                <select id="tahunProduct" name="tahunProduct" class="form-control">
                    <option selected disabled>Pilih Tahun</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <div class="me-2 mt-4">
                <button type="submit" class="btn btn-primary" id="filterProduct"
                    style="background-color: #002c4f;border: none">Filter</button>
                <a class="btn btn-success" id="filter" href="{{ route('downloadExcelOrder') }}"
                    style="background-color: green;border: none"><i class="bi bi-file-earmark-excel-fill"
                    style="font-size: 1.5rem"></i></a>
            </div>
        </div>
        <canvas id="productChart"></canvas>
    </div>

    <div class="container text-center">
        <div class="col-md-3 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <p>Total Pendapatan : Rp{{ number_format($totalIncome, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var ctx = document.getElementById('userChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Total User',
                    data: @json($data['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        document.getElementById('filter').addEventListener('click', function() {
            var bulan = document.getElementById('bulan').value;
            var tahun = document.getElementById('tahun').value;

            $.ajax({
                type: 'GET',
                url: '{{ route('filterData') }}',
                data: {
                    bulan: bulan,
                    tahun: tahun
                },
                success: function(response) {
                    updateChart(response.labels, response.data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function updateChart(labels, data) {
            var userChart = Chart.getChart('userChart');
            if (userChart) {

                userChart.data.labels = labels;
                userChart.data.datasets[0].data = data;
                userChart.update();
            } else {
                var ctx = document.getElementById('userChart').getContext('2d');
                userChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total User',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    </script>

    <script>
        var ctx = document.getElementById('productChart').getContext('2d');
        var chartData = @json($chartData);

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Total Penjualan',
                    data: chartData.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        document.getElementById('filterProduct').addEventListener('click', function() {
            var bulanP = document.getElementById('bulanProduct').value;
            var tahunP = document.getElementById('tahunProduct').value;

            $.ajax({
                type: 'GET',
                url: '{{ route('filterProduct') }}',
                data: {
                    bulanProduct: bulanP,
                    tahunProduct: tahunP
                },
                success: function(response) {
                    updateChartProduct(response.labels, response.data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function updateChartProduct(labels, data) {
            var productChart = Chart.getChart('productChart');
            if (productChart) {
                productChart.data.labels = labels;
                productChart.data.datasets[0].data = data;
                productChart.update();
            } else {
                var ctx = document.getElementById('productChart').getContext('2d');
                productChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Penjualan',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    </script>
@endsection
