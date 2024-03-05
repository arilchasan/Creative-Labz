<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Detail Order</h2>
        <div class="row g-3 mt-2">
            <div class="col-md-6 text-center">
                <img src="{{ asset('assets/product/' . $order->cart->product->images[0]->image) }}" alt=""
                    class="d-flex mx-auto justify-content-center align-items-center img-fluid" style="width: 300px">
                <label class="form-label mt-2 text-center" for="image">Image</label>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="name">Nama Product</label>
                        <p>{{ $order->cart->product->name }}</p>
                        {{-- <input id="name" type="text" name="name" value="{{ $order->cart->product->name }}"
                            class="form-control" readonly> --}}
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="qty">Jumlah</label>
                        <p>{{ $order->cart->qty }}</p>
                        {{-- <input id="qty" type="text" name="qty" value="{{ $order->cart->qty }}"
                            class="form-control" readonly> --}}
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="price">Price</label>
                        <p>Rp{{ number_format($order->cart->productDetail->price, 0, ',', '.') }}</p>
                        {{-- <input id="price" type="text" name="price"
                            value="Rp{{ number_format($order->cart->productDetail->price, 0, ',', '.') }}"
                            class="form-control" readonly> --}}
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="weight">Weight</label>
                        <p>{{ $order->cart->product->weight }} gram</p>
                        {{-- <input id="weight" type="text" name="weight" value="{{ $order->cart->product->weight }} gram"
                            class="form-control" readonly> --}}
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nic_id">Nic</label>
                        <p>{{ $order->cart->nic }}</p>
                        {{-- <input id="nic_id" type="text" name="nic" value="{{ $order->cart->nic }}"
                            class="form-control" readonly> --}}
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="total">Total</label>
                        <p>Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        {{-- <input id="total" type="text" name="total"
                            value="Rp{{ number_format($order->total, 0, ',', '.') }}" class="form-control" readonly> --}}
                    </div>
                    <div class="col-md-12 ">
                        <label class="form-label" for="resi">No.Resi</label>
                        <p>{{ $order->resi }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="information">Information</label>
                {{-- <textarea class="form-control" id="information" type="text" name="information" readonly>{!!$cart->product->information !!}</textarea> --}}
                {!! $order->cart->product->information !!}
            </div>
            <div class="col-md-12">
                <label class="form-label" for="description">Description</label>
                {{-- <textarea class="form-control" id="description" type="text" name="description" readonly>{{ $desc }}</textarea> --}}
                {!! $order->cart->product->description !!}
            </div>
        </div>
        <h2 class="text-md font-semibold capitalize mt-3" style="font-style: italic">Detail Customers</h2>
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label class="form-label" for="name">Nama Customers</label>
                <p>{{ $order->user->name ?? 'Not Registered' }}</p>
                {{-- <input id="name" type="text" name="name" value="{{ $order->user->name }}" class="form-control"
                    readonly> --}}
            </div>
            <div class="col-md-6">
                <label class="form-label" for="email">Email</label>
                <p>{{ $order->user->email ?? 'Not Registered' }}</p>
                {{-- <input id="email" type="text" name="email" value="{{ $order->user->email }}" class="form-control" readonly> --}}
            </div>
            <div class="col-md-6">
                <label class="form-label" for="status">Status</label>
                <p>
                    <span id="orderStatus" class="badge ms-2"
                        style="background-color:
                        @if ($order->status == 'pending') orange;
                        @elseif($order->status == 'success') green;
                        @elseif($order->status == 'failed') red; @endif">
                        {{ $order->status }}
                    </span>
                </p>
                {{-- <input id="status" type="text" name="status" value="{{ $order->status == 'success' ? 'Berhasil' : $order->status }}"
                class="form-control" readonly> --}}
            </div>
            <div class="col-md-6">
                <label class="form-label" for="payment">Payment</label>
                <p>{{ $order->payment }}</p>
                {{-- <input id="payment" type="text" name="payment" value="{{ $order->payment }}" class="form-control" readonly> --}}
            </div>
            <div class="col-md-12">
                <label class="form-label" for="address">Alamat</label>
                <p>{{ $order->address->full_address }}</p>
                {{-- <input id="address" type="text" name="address" value="{{ $order->address->full_address }}" class="form-control" readonly> --}}
            </div>
        </div>
        <div class="text-end mt-4">
            <a href="/dashboard/order/req-order" class="btn btn-secondary ml-2">Kembali</a>
        </div>
    </section>
@endsection
