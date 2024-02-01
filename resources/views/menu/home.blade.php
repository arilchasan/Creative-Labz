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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total Admin</p>
                                <h1>{{$admin}}</h1>
                            </div>
                            <div class="col-md-6 circle-icon" style="background-color: #ffc107;color:black">
                                <i class="fa-solid fa-user-secret fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total Customer</p>
                                <h1>{{$user}}</h1>
                            </div>
                            <div class="col-md-6 circle-icon" style="background-color: #3498db;color:white">
                                <i class="fas fa-users fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Pesan Masuk</p>
                                <h1>{{$contact}}</h1>
                            </div>
                            <div class="col-md-6 circle-icon" style="background-color: #3498db;color:white">
                                <i class="fas fa-envelope fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" >
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total Product</p>
                                <h1>{{$product}}</h1>
                            </div>
                            <div class="col-md-6 circle-icon" style="background-color: #15acc5;color:white">
                                <i class="fa-solid fa-flask fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
