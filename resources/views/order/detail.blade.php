<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Checkout Order</h2>
        <div class="row g-3 mt-2">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center fade show">
                    <i class="bi-check-circle-fill"></i>
                    <strong class="mx-2">Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="wrapper-tabel">
                <form action="{{ route('order.updateCart', ['id' => $order->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <table class="table table-responsive">
                        <thead class="w-100">
                            <tr class="w-100" width="100%">
                                <th scope="col" width="10%"></th>
                                <th scope="col" width="10%"></th>
                                <th scope="col" width="20%"> Product </th>
                                <th scope="col" width="20%"> Price </th>
                                <th scope="col" width="20%"> Quantity </th>
                                <th scope="col" width="20%"> Discount </th>
                                <th scope="col" width="20%"> Subtotal </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-row">
                                <th scope="row" class="delete" style="text-align: center; vertical-align: middle;">
                                    <a class="btn btn-danger" onclick="deleteConfirmation({{$order->id}})">Delete</a>
                                </th>
                                <td class="image">
                                    <img src="{{ asset('assets/product/' . $order->cart->product->images[0]->image) }}" alt="">
                                </td>
                                <td class="name"><span class="item-label">
                                        <a href="">{{ $order->cart->product->name }} -
                                            {{ $order->cart->nic }}</a>
                                </td>
                                <td class="price"><span
                                        class="item-label">Rp{{ number_format($price->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="quantity">
                                        <input type="number" id="qty" name="qty" min="0" title="Qty"
                                            value="{{ $order->cart->qty }}">
                                    </div>
                                </td>
                                <td class="discount"><span
                                        class="item-label">Rp{{ number_format($order->promo, 0, ',', '.') }}
                                <td class="subtotal">Rp{{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <input class="form-control w-25" name="coupon" type="text" placeholder="Coupon code">
                    {{-- <button class="btn btn-info">Apply coupon</button> --}}
                    <div class="btn btn-info float-right text-right">
                        <button type="submit">Update cart</button>
                    </div>
                </form>
            </div>

            <form action="/dashboard/order/postAddress-{{ $order->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label" for="">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="">
                    </div>
                    {{-- <div class="col-md-12">
                        <label class="form-label" for="">Company Name (optional)</label>
                        <input type="text" name="" class="form-control" placeholder="">
                    </div> --}}
                    <label for="province">Province:</label>
                    <select id="province" class="form-control" name="province"></select>

                    <label for="city">City:</label>
                    <select id="city" class="form-control" name="city"></select>

                    <label for="subdistrict">Subdistrict:</label>
                    <select id="subdistrict" class="form-control" name="subdistrict"></select>

                    <div class="col-md-12">
                        <label class="form-label" for="">Street Address </label>
                        <input type="text" name="address" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="">Zip Code</label>
                        <input type="text" name="zip_code" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="">
                    </div>
                </div>

                <input type="hidden" name="province_name" id="province_name" value="">
                <input type="hidden" name="city_name" id="city_name" value="">
                <input type="hidden" name="subdistrict_name" id="subdistrict_name" value="">
                <div class="btn btn-success float-right text-right">
                    <button type="submit">Place Order</button>
                </div>

            </form>
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/order/all" class="btn btn-secondary ml-2">Kembali</a>
        </div>

    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to fetch and populate provinces
        function getProvinces() {
            fetch('/get-provinces')
                .then(response => response.json())
                .then(data => {
                    var provinces = data.rajaongkir.results;
                    var provinceSelect = document.getElementById('province');


                    provinces.forEach(function(province) {
                        var option = document.createElement('option');
                        option.value = province.province_id;
                        option.text = province.province;
                        provinceSelect.add(option);
                        // option.setAttribute('province', province.province);
                    });
                });

            // provinceSelect.value = province.province;
        }

        // Function to fetch and populate cities based on the selected province
        function getCities(provinceId) {
            fetch('/get-cities/' + provinceId)
                .then(response => response.json())
                .then(data => {
                    var cities = data.rajaongkir.results;
                    var citySelect = document.getElementById('city');
                    var subdistrictSelect = document.getElementById('subdistrict');


                    citySelect.innerHTML = ''; // Clear existing options
                    subdistrictSelect.innerHTML = ''; // Clear subdistrict options

                    cities.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.city_id;
                        option.text = city.city_name;
                        citySelect.add(option);
                        // option.setAttribute('city', city.city_name);
                    });
                });
        }

        // Function to fetch and populate subdistricts based on the selected city
        function getSubdistricts(cityId) {
            fetch('/get-subdistricts/' + cityId)
                .then(response => response.json())
                .then(data => {
                    var subdistricts = data.rajaongkir.results;
                    var subdistrictSelect = document.getElementById('subdistrict');


                    subdistrictSelect.innerHTML = ''; // Clear existing options

                    subdistricts.forEach(function(subdistrict) {
                        var option = document.createElement('option');
                        option.value = subdistrict.subdistrict_id;
                        option.text = subdistrict.subdistrict_name;
                        subdistrictSelect.add(option);
                        // option.setAttribute('subdistrict', subdistrict.subdistrict_name);
                    });
                });
        }

        // Initialize the provinces dropdown on page load
        getProvinces();

        document.getElementById('province').addEventListener('change', function() {
            var selectedProvince = this.value;
            var selectedProvinceName = this.options[this.selectedIndex].text;
            if (selectedProvince !== '') {
                getCities(selectedProvince);

                // Update hidden input field with the province name
                document.getElementById('province_name').value = selectedProvinceName;
            }
        });

        // Handle city change to fetch subdistricts
        document.getElementById('city').addEventListener('change', function() {
            var selectedCity = this.value;
            var selectedCityName = this.options[this.selectedIndex].text;
            if (selectedCity !== '') {
                getSubdistricts(selectedCity);

                // Update hidden input field with the city name
                document.getElementById('city_name').value = selectedCityName;
            }
        });

        // Handle subdistrict change (if needed)
        document.getElementById('subdistrict').addEventListener('change', function() {
            var selectedSubdistrict = this.value;
            var selectedSubdistrictName = this.options[this.selectedIndex].text;
            if (selectedSubdistrict !== '') {
                // Update hidden input field with the subdistrict name
                document.getElementById('subdistrict_name').value = selectedSubdistrictName;
            }
        });
    });
</script>

<script>
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus dari order secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/dashboard/order/delete-order/" + id;
            }
        })
    }

    function closeAlert(alertId) {
        var alert = document.getElementById(alertId);
        if (alert) {
            alert.style.display = 'none';
        }
    }
</script>
