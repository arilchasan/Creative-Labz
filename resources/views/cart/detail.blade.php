<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Detail Product</h2>
        <div class="row g-3 mt-2">
            <div class="col-md-6 text-center">
                <img src="{{ asset('assets/product/' . $cart->product->images[0]->image) }}" alt=""
                    class="d-flex mx-auto justify-content-center align-items-center img-fluid" style="width: 300px">
                <label class="form-label mt-2 text-center" for="image">Image</label>
            </div>
            <div class="col-md-6">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ $cart->product->name }}"
                        class="form-control" readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="price">Price</label>
                    <input id="price" type="text" name="price"
                        value="Rp{{ number_format($price, 0, ',', '.') }}" class="form-control"
                        readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="weight">Weight</label>
                    <input id="weight" type="text" name="weight" value="{{ $cart->product->weight }}"
                        class="form-control" readonly>
                </div>
                <div class="col-md-12 ">
                    <label class="form-label" for="nic_id">Nic</label>
                    <input id="nic_id" type="text" name="nic" value="{{ $cart->nic }}" class="form-control"
                        readonly>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="information">Information</label>
                {{-- <textarea class="form-control" id="information" type="text" name="information" readonly>{!!$cart->product->information !!}</textarea> --}}
                <div class="form-control" style="resize: both; overflow: auto;">{!! $cart->product->information !!}</div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="description">Description</label>
                {{-- <textarea class="form-control" id="description" type="text" name="description" readonly>{{ $desc }}</textarea> --}}
                <div class="form-control" style="resize: both; overflow: auto;">{!! $cart->product->description !!}</div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/cart/all" class="btn btn-secondary ml-2" style="font-size: 16px">Kembali</a>
            <a href="javascript:void(0);" onclick="submitForm()" class="info btn btn-success">
                <i class="fa-solid fa-file-invoice-dollar" style="color: #ffffff; font-size: 22px"></i>
            </a>
        </div>

        <form id="orderForm" action="/dashboard/cart/order" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="cart_id" value="[{{ $cart->id }}]">
        </form>

    </section>
@endsection
<script>
    function submitForm() {
        document.getElementById('orderForm').submit();
    }
</script>
