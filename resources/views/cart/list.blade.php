<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="p-5 mx-2 mt-2 shadow rounded">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <div class="row g-3 mt-2">
                <div class="col-md-5">
                    <div class="image-container d-flex flex-wrap" style="display: flex">
                        @foreach ($products as $product)
                            @foreach ($product->images as $image)
                                <img src="{{ asset('assets/product/' . $image->image) }}" alt=""
                                    class="mx-2 my-2 img-fluid" style="width: 200px">
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <div class="col-md-7 d-flex align-items-start flex-column">
                    <div class="dropdown w-50 text-center mb-2">
                        <select name="product_id" class="form-control text-center" id="productDropdown1">
                            <option value="" selected disabled>Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dropdown w-50 text-center mb-2">
                        <select name="nic" class="form-control text-center" id="nicStockDropdown1" disabled>
                            <option value="" selected disabled>Select NIC - Stock</option>
                        </select>
                    </div>
                    <div class="form-group w-50 text-center mb-2">
                        <input type="number" name="qty" class="form-control" id="qtyInput1" placeholder="Quantity"
                            min="1" required>
                    </div>

                    <div class="dropdown w-50 text-center mb-2">
                        <select name="product_id" class="form-control text-center" id="productDropdown2">
                            <option value="" selected disabled>Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dropdown w-50 text-center mb-2">
                        <select name="nic" class="form-control text-center" id="nicStockDropdown2" disabled>
                            <option value="" selected disabled>Select NIC - Stock</option>
                        </select>
                    </div>
                    <div class="form-group w-50 text-center mb-2">
                        <input type="number" name="qty" class="form-control" id="qtyInput2" placeholder="Quantity"
                            min="1" required>
                    </div>

                    <button type="submit" class="w-50 success btn btn-success mt-2"
                        style="color: white;
            background-color: green;">+ Cart</button>
                </div>
        </form>
        </div>
    </section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let productDropdown1 = document.getElementById('productDropdown1');
        let nicStockDropdown1 = document.getElementById('nicStockDropdown1');
        let qtyInput1 = document.getElementById('qtyInput1');

        let productDropdown2 = document.getElementById('productDropdown2');
        let nicStockDropdown2 = document.getElementById('nicStockDropdown2');
        let qtyInput2 = document.getElementById('qtyInput2');

        productDropdown1.addEventListener('change', function() {
            let productId = productDropdown1.value;
            if (productId !== "") {
                fetch(`/dashboard/get-nic/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateNicStockDropdown(data.productDetail, nicStockDropdown1);
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                resetDropdown(nicStockDropdown1);
            }
        });

        productDropdown2.addEventListener('change', function() {
            let productId = productDropdown2.value;
            if (productId !== "") {
                fetch(`/dashboard/get-nic/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateNicStockDropdown(data.productDetail, nicStockDropdown2);
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                resetDropdown(nicStockDropdown2);
            }
        });

        function populateNicStockDropdown(productDetail, dropdown) {
            dropdown.innerHTML = '<option value="" selected disabled>Select NIC - Stock</option>';
            dropdown.removeAttribute('disabled');

            productDetail.forEach(detail => {
                let option = document.createElement('option');
                option.value = detail.nic;
                option.textContent = `${detail.nic} - ${detail.stock}`;
                dropdown.appendChild(option);
            });
        }

        function resetDropdown(dropdown) {
            dropdown.innerHTML = '<option value="" selected disabled>Select NIC - Stock</option>';
            dropdown.setAttribute('disabled', 'disabled');
        }
    });
</script>
