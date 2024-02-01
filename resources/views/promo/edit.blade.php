<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Edit Code Promo</h2>

        <form action="/dashboard/promo/update-{{ $promo->code }}" method="POST">
            @csrf
            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <label class="form-label" for="code">Code</label>
                    <input id="code" type="text" name="code" value="{{ old('code', $promo->code) }}"
                        class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="discount">Discount</label>
                    <input id="discount" type="number" min="0" name="discount"
                        value="{{ old('discount', $promo->discount) }}" class="form-control"
                        oninput="validity.valid||(value='');" required>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="/dashboard/promo/all" class="btn btn-secondary ml-2">Kembali</a>
                <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button>
            </div>
        </form>
    </section>
@endsection
