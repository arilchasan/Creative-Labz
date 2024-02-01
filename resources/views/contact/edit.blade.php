
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

<section class="p-5 mx-2 mt-2 shadow rounded">
    <h2 class="text-lg font-semibold capitalize">Detail Pesan</h2>

    <form action="/dashboard/contact/update-{{$contact->name}}" method="POST">
        @csrf
        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label" for="name">Name</label>
                <input id="name" type="text" name="name" value="{{old('name', $contact->name)}}"
                    class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="text" name="email" value="{{old('email', $contact->email)}}"
                    class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="password">Message</label>
                <textarea class="form-control" name="message"  required >{{old('message',$contact->message)}}</textarea>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/contact/all" class="btn btn-secondary ml-2">Kembali</a>
            <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button>
        </div>
    </form>
</section>

@endsection

