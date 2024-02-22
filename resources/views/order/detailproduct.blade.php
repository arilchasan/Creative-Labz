<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css"
        integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Detail Order</h2>
        <div class="row g-3 mt-2">
            <div class="col-lg-7 ">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">Order ID: {{ substr($order->code_transfer, -5) }}</h4>
                                <div class="d-flex align-items-center">
                                    <small>Tanggal Order: {{ $date }}</small>
                                    <span id="orderStatus" class="badge ms-2"
                                        style="background-color:
                                        @if ($order->status == 'pending') orange;
                                        @elseif($order->status == 'success')
                                        green;
                                        @elseif($order->status == 'failed')
                                        red; @endif">
                                        {{ $order->status }}
                                    </span>

                                </div>
                            </div>
                            <div>
                                <a href="{{ asset('assets/transfer/' . $order->transfer) }}" data-lightbox="transfer"
                                    class="btn btn-primary" data-title="Bukti Transfer">Bukti
                                    Transfer</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table text-nowrap mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>

                                        <th scope="col">Product</th>
                                        <th scope="col">Items</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a><img src="{{ asset('assets/product/' . $order->cart->product->images[0]->image) }}"
                                                        alt="Image" class="img-4by3-md rounded-3 "
                                                        style="height: 40px"></a>
                                                <div class="ms-3">
                                                    <h5 class="mb-0"> <a href="#!"
                                                            class="text-inherit">{{ $order->cart->product->name }}</a></h5>
                                                    <small>NIC: {{ $order->cart->productDetail->nic }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $order->cart->qty }}</td>
                                        <td>Rp{{ number_format($order->cart->productDetail->price * $order->cart->qty, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-4 mt-4 mt-lg-0">
                    <div class="card-header">
                        <h4 class="mb-0">Order Details</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Descriptions</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sub Total :</td>
                                    <td>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Discount : </td>
                                    <td>Rp{{ number_format($order->promo, 0, ',', '.') }}</td>

                                </tr>
                                <tr>

                                    <td>Total :</td>
                                    <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>

                                </tr>
                                <form id="updateForm" method="POST"
                                    action="{{ route('order.updateStatus', ['id' => $order->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td>Status :</td>
                                        <td>
                                            <select name="status" id="status" class="form-select">
                                                <option value="pending" @if ($order->status == 'pending') selected @endif>
                                                    Pending</option>
                                                <option value="success" @if ($order->status == 'success') selected @endif>
                                                    Success</option>
                                                <option value="failed" @if ($order->status == 'failed') selected @endif>
                                                    Failed</option>
                                            </select>
                                        </td>
                                    </tr>
                                </form>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Payment Details</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex justify-content-between mb-2"><span>Code Transaksi :
                                    </span> <span class="text-dark">#{{ $order->code_transfer }}</span></li>
                                <li class="d-flex justify-content-between mb-2"><span>Metode Pembayaran :
                                    </span> <span class="text-dark">
                                        @if ($order->payment == 'transfer-payment-bca')
                                            BCA
                                        @elseif($order->payment == 'online-payment')
                                            Online Payment
                                        @elseif($order->payment == 'gopay')
                                            Gopay
                                        @endif
                                    </span></li>
                                <li class="d-flex justify-content-between"><span>Total : </span>
                                    <span class="text-dark ">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="text-end mt-4">
            <a href="/dashboard/order/all" class="btn btn-secondary ml-2" style="font-size: 16px">Kembali</a>
        </div>



    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox-plus-jquery.js"
    integrity="sha512-oaWLach/xXzklmJDBjHkXngTCAkPch9YFqOSphnw590sy86CVEnAbcpw17QjkUGppGmVJojwqHmGO/7Xxx6HCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#status').change(function() {
            var status = $('#status').val();

            // Update status badge color
            if (status === 'pending') {
                $('#orderStatus').removeClass().addClass('badge ms-2').addClass('bg-warning').text(
                    status);
            } else if (status === 'success') {
                $('#orderStatus').removeClass().addClass('badge ms-2').addClass('bg-success').text(
                    status);
            } else if (status === 'failed') {
                $('#orderStatus').removeClass().addClass('badge ms-2').addClass('bg-danger').text(
                    status);
            }
            $.ajax({
                url: "{{ route('order.updateStatus', ['id' => $order->id]) }}",
                type: "POST",
                data: {
                    status: status,
                    payment_status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    // Handle success response if needed
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    // Handle error response if needed
                }
            });
        });
    });
</script>
