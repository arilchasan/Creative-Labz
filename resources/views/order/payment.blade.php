<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    <section class="p-5 mx-2 mt-2 shadow rounded">

        <h2 class="text-lg font-semibold capitalize">Payment</h2>
        <form action="/dashboard/order/postPayment-{{ $order->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="payment">
                <div class="payment-method">
                    <input type="radio" id="transfer-payment-bca" name="payment" value="transfer-payment-bca"
                        {{ $order->payment == 'transfer-payment-bca' ? 'checked' : '' }}>
                    <label for="transfer-payment-bca">Transfer Payment BCA</label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="online-payment" name="payment" value="online-payment"
                        {{ $order->payment == 'online-payment' ? 'checked' : '' }}>
                    <label for="online-payment">Online Payment</label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="gopay" name="payment" value="gopay"
                        {{ $order->payment == 'gopay' ? 'checked' : '' }}>
                    <label for="gopay">GoPay</label>
                </div>
            </div>
                </div>
                <div class="col-md-9">
                    <button class="btn btn-outline-success" type="submit">Pilih</button>
                </div>
            </div>
        </form>
        @if ($order->payment != null)
            <h2 class="ml-3 text-center" style="font-style: italic; font-size: 17px">Kode Pembayaran</h2>
            @if($order->payment == 'online-payment')
                <h4 class="ml-3 text-center" style="font-style: italic; font-size: 17px">tugigab{{ $numeric }}</h4>
            @endif
            @if($order->payment == 'gopay')
                <h4 class="ml-3 text-center" style="font-style: italic; font-size: 17px">tugigab 0812345678</h4>
            @endif
            @if($order->payment == 'transfer-payment-bca')
                <h4 class="ml-3 text-center" style="font-style: italic; font-size: 17px">tugigab{{ $numeric }}
                </h4>
            @endif
            <form action="{{ route('order.uploadTransfer', ['id' => $order->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-11">
                        <label class="form-label" for="">Bukti Transfer</label>
                        <input id="transfer" type="file" name="transfer" class="form-control"
                            accept="image/jpeg, image/png" placeholder="" onchange="previewImage(event)" required>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-outline-secondary" style="margin-top: 30px" type="submit">Selanjutnya</button>
                    </div>
                    @if ($order->transfer != null)
                        <img id="image-preview" src="{{ asset('assets/transfer/' . $order->transfer) }}" alt="Image Preview"
                            style="max-width: 300px; max-height: 300px; margin-top: 10px;">
                    @endif
                    <img id="image-preview" src="#" alt="Image Preview"
                        style="display: none; max-width: 300px; max-height: 300px; margin-top: 10px;">
                </div>
            </form>
            {{-- <a class="btn btn-warning" type="button" href="{{ route('order.reqOrder') }}"> Selanjutnya </a> --}}
        @endif
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function previewImage(event) {
        var input = event.target;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result).show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
