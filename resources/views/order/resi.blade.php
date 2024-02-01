<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Update Resi</h2>
        <div class="row g-3 mt-2">
            <form action="/dashboard/order/postResi-{{ $order->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="form-label" >Bukti Tansfer</label>
                <img id="image-preview" src="{{ asset('assets/transfer/' . $order->transfer) }}" alt="Image Preview"
                style="max-width: 300px; max-height: 300px; margin-top: 10px;">
                <div class="col-md-12 mt-3">
                    <label class="form-label" for="resi">Resi</label>
                    <input id="resi" placeholder="Masukkan Resi" type="text" name="resi" class="form-control"
                        required
                        @if ($order->resi) value="{{ $order->resi }}"
                    @else
                        value="{{ $randomNumber }}" @endif>
                </div>
                <button class="btn btn-outline-success mt-2" type="submit">Update</button>
            </form>
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/order/req-order" class="btn btn-secondary ml-2">Kembali</a>
        </div>

    </section>
@endsection
