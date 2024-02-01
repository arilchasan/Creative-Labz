<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <div class="container">
        <h2 class="ml-3 text-xl font-bold text-gray-900">Detail News</h2>
        <div class="row justify-content-center shadow-md rounded-lg mx-2">
            <div class="col-md-8 overflow-hidden mx-5 my-2">
                <img src="{{ asset('assets/news/' . $news->thumbnail) }}" alt=""
                    class="mx-auto d-flex justify-content-center align-items-center img-fluid" style="border: 1px solid black;width: 300px;">
                <div class="p-4 text-center">
                    <h2 class="text-2xl text-center font-bold mb-2">{{ $news->title }}</h2>
                </div>
                {!! htmlspecialchars_decode($news->description) !!}
                <br>
            </div>
        </div>
        <a href="/dashboard/news/all" class="btn btn-secondary w-20 ml-3 mt-2 text-sm">Kembali</a>
        <div class="pb-5"></div>
    </div>
@endsection
