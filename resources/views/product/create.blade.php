<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
@section('container')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">Tambah Product</h2>
        <form id="productForm" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="formContainer">
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Name</label>
                        <input id="name" type="text" name="name" class="form-control" required
                            placeholder="Masukkan Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="weight">Berat</label>
                        <input id="weight" type="text" name="weight" class="form-control" required
                            placeholder="Masukkan Berat">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="information">Information</label>
                        <textarea id="information" placeholder="Masukkan Information" type="text" name="information" class="form-control"
                            required></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="description">Deskripsi</label>
                        <textarea id="description" placeholder="Masukkan Deskripsi" type="text" name="description" class="form-control"
                            required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="image">Image</label>
                        <input id="image" type="file" name="image[]" accept="image/jpeg, image/png"
                            class="form-control" multiple onchange="previewImages(event)" required>
                        <div id="image-preview-container" style="display: flex; flex-wrap: wrap; margin-top: 10px;"></div>
                    </div>
                    <div id="additionalFieldsContainer" style="display: none;">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label" for="price">Price</label>
                                <input id="price" type="number" min="1" name="price[]" class="form-control"
                                    placeholder="Masukkan Price">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="stock">Stock</label>
                                <input id="stock" type="number" min="1" name="stock[]" class="form-control"
                                    placeholder="Masukkan Stock">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="nic">Nic</label>
                                <input id="nic" type="text" name="nic[]" class="form-control"
                                    placeholder="Masukkan Nic">
                                {{-- <div class="dropdown">
                                    <select id="nic_id" name="nic_id[]" class="form-control">
                                        <option value="" selected disabled>Select Nic</option>
                                        @foreach ($nic as $nicotin)
                                            <option value="{{ $nicotin->id }}">{{ $nicotin->nic }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <button type="button" class="addBtn btn mt-3" onclick="addForm()"
                style="background-color: blue; color: white;">Tambahkan Detail
                Produk</button>
            <div class="text-end mt-4">
                <a href="/dashboard/product/all" class="btn btn-secondary ml-2">Kembali</a>
                <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button>
            </div>
        </form>

    </section>
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('information');
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function previewImages(event) {
        var input = event.target;
        var container = $('#image-preview-container');
        container.empty();

        if (input.files && input.files.length > 0) {
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imageContainer = $('<div>').css('position', 'relative');
                    var image = $('<img>').attr('src', e.target.result).css({
                        'max-width': '300px',
                        'max-height': '300px',
                        'margin': '5px',
                    });

                    var deleteButton = $('<button>').html(
                        '<i class="fas fa-trash" ></i>').css({
                        'position': 'absolute',
                        'top': '10',
                        'right': '10',
                        'background': 'transparent',
                        'border': 'none',
                        'color': 'red',
                        'cursor': 'pointer',
                    }).click(function() {
                        imageContainer.remove();
                        updateFileInput();
                    });

                    imageContainer.append(image, deleteButton);
                    container.append(imageContainer);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    function updateFileInput() {
        var fileInput = $('#image')[0];
        var files = [];

        $('#image-preview-container img').each(function() {
            var src = $(this).attr('src');
            var file = dataURLtoFile(src, 'image');
            files.push(file);
        });

        if (files.length > 0) {
            // Create a new DataTransfer object and add the files to it
            var dataTransfer = new DataTransfer();
            for (var i = 0; i < files.length; i++) {
                dataTransfer.items.add(files[i]);
            }

            // Set the files property of the file input
            fileInput.files = dataTransfer.files;
        } else {
            // If no files left, clear the file input
            fileInput.value = null;
        }
    }


    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(',');
        var mime = arr[0].match(/:(.*?);/)[1];
        var extension = mime.split('/')[1];

        // Extracting base64 data from data URL
        var bstr = atob(arr[1]);
        var n = bstr.length;
        var u8arr = new Uint8Array(n);

        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }

        // Creating a File object with the correct file extension
        return new File([u8arr], filename + '.' + extension, {
            type: mime
        });
    }


    var formIndex = 0;

    function addForm() {
        var additionalFieldsContainer = document.getElementById('additionalFieldsContainer');
        var clone = additionalFieldsContainer.cloneNode(true);
        clone.querySelectorAll('input, select').forEach(function(field) {
            var currentName = field.getAttribute('name');
            var newName = currentName.replace(/\[\d+\]/g, '[' + formIndex + ']');
            field.setAttribute('name', newName);
        });

        formIndex++;
        clone.style.display = 'block';
        document.getElementById('formContainer').appendChild(clone);
    }
</script>
