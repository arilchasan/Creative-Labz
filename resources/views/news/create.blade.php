<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Tambah News</h2>

        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <label class="form-label" for="title">Tittle</label>
                    <input id="title" type="text" name="title" class="form-control" required
                        placeholder="Masukkan Tittle">
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" placeholder="Masukkan Deskripsi" type="text" name="description" class="form-control"
                        required></textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="category_id">Category</label>
                    <div class="dropdown">
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="" selected disabled>Select Category</option>
                            @foreach ($category_product as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="thumbnail">Thumbnail</label>
                    <input id="thumbnail" type="file" name="thumbnail" accept="image/jpeg, image/png" class="form-control"
                        onchange="previewImage(event)" required>
                    <img id="image-preview" src="#" alt="Image Preview"
                        style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;border: 1px solid black">
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="author">Author</label>
                    <input id="author" type="text" name="author" class="form-control" required
                        placeholder="Masukkan Author">
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="/dashboard/news/all" class="btn btn-secondary ml-2">Kembali</a>
                <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button>
            </div>
        </form>
    </section>
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
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
