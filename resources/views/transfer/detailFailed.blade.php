<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Upload Bukti Pembayaran</h2>
        <form action="{{ route('order.pendingPayment', ['id' => $order->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-11">
                    <label class="form-label" for="">Bukti Transfer</label>
                    <input id="transfer" type="file" name="transfer" class="form-control" accept="image/jpeg, image/png"
                        placeholder="" onchange="previewImage(event)" required>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-secondary" style="margin-top: 30px" type="submit">Upload</button>
                </div>
                @if ($order->transfer != null)
                    <img id="image-preview" src="{{ asset('assets/transfer/' . $order->transfer) }}" alt="Image Preview"
                        style="max-width: 300px; max-height: 300px; margin-top: 10px;">
                @endif
                <img id="image-preview" src="#" alt="Image Preview"
                    style="display: none; max-width: 300px; max-height: 300px; margin-top: 10px;">
            </div>
        </form>
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
