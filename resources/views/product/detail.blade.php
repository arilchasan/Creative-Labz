<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Detail Product</h2>
        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label" for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="information">Information</label>
                <textarea class="form-control" id="information" type="text" name="information" readonly>{{ $info }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" type="text" name="description" readonly>  {{ $desc }}</textarea> 
                {{ $desc }}

            </div>
            <div class="col-md-12">
                <label class="form-label" for="weight">Weight</label>
                <input id="weight" type="text" name="weight" value="{{ old('weight', $product->weight) }}"
                    class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="nic_id">Nic</label>
                <input id="nic_id" type="text" name="nic_id"
                    value="{{ implode(', ', $productDetails->pluck('nic')->toArray()) }}" class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="image">Image</label>

                <div class="image-container d-flex" style="display: flex;justify-content: space-between; ">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('assets/product/' . $image->image) }}" alt=""
                            class="w-25 mx-auto d-flex justify-content-center align-items-center img-fluid p-2">
                    @endforeach
                </div>

            </div>
            <div class="col-md-12">
                <label class="form-label" for="stock">Stock</label>
                @foreach ($productDetails as $productDetail)
                    <p>NIC: {{ $productDetail->nic }} - Rp{{ number_format($productDetail->price, 0, ',', '.') }} - Stock:
                        {{ $productDetail->stock }} Botol</p>
                @endforeach
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/product/all" class="btn btn-secondary ml-2">Kembali</a>
            {{-- <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button> --}}
        </div>

    </section>
@endsection
