{{-- Bootstrap style DataTaables --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
@extends('layouts.app')
@section('container')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <style>
        @import url('/assets/css/table.css');

        .alert {
            margin-right: 10px;
        }

        .success {
            color: white;
            background-color: green;
        }
    </style>
    <section class="p-5 mx-2 mt-2 shadow rounded">
        <h2 class="text-lg font-semibold capitalize">{{ $product->name }}</h2>
        <form action="/dashboard/cart/add/{{ $product->id }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row g-3 mt-2">
                <div class="col-md-5">
                    {{-- <label class="form-label" for="image">Image</label> --}}
                    <div class="image-container d-flex" style="display: flex">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('assets/product/' . $image->image) }}" alt=""
                            class="d-flex mx-2 justify-content-center align-items-center img-fluid" style="width: 200px">
                    @endforeach
                    </div>

                </div>
                <div class="col-md-7 d-flex align-items-start flex-column">
                    <div class="dropdown w-50 text-center mb-2">
                        <select name="nic" class="form-control text-center">
                            <option value="" selected disabled>Select Nic - Stock</option>
                            @foreach ($productDetails as $productDetail)
                                <option value="{{ $productDetail->nic }}">{{ $productDetail->nic }} -
                                    {{ $productDetail->stock }} Botol</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="number" name="qty" id="qty" class="form-control w-50 mb-2" placeholder="Qty">
                    <button type="submit" class="w-50 success btn btn-success mt-2">+ Cart</button>
                </div>
                <div class="text-end mt-4">
                    <a href="/dashboard/product/all" class="btn btn-secondary ml-2">Kembali</a>
                    {{-- <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button> --}}
                </div>
            </div>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            var table = $('#cart-table').DataTable({
                ordering: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 500,
                pageLength: 5,
                pagingType: 'simple',
                lengthMenu: [5, 10, 25, 50, 100],
                ajax: "{{ route('product.all') }}",
                language: {
                    "paginate": {
                        "next": "<i class='fas fa-angle-right' ></i>",
                        "previous": "<i class='fas fa-angle-left' ></i>"
                    },
                    // "loadingRecords": "Loading...",
                    // "processing": "Processing...",
                    "search": "Cari:",
                    "searchPlaceholder": "Cari berdasarkan nama",
                    "emptyTable": "Tidak ada data",
                    "lengthMenu": "_MENU_ ",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "info": "Menampilkan  _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 dari 0 data",
                    "infoFiltered": "(filter dari _MAX_ total data)",

                },
                columns: [
                    // {
                    //     data: null,
                    //     "sortable": false,
                    //     "searchable": false,
                    //     render: function(data, type, row, meta) {
                    //         return meta.row + meta.settings._iDisplayStart + 1;
                    //     }
                    // },
                    // {
                    //     data: 'name',
                    //     name: 'name',
                    //     orderable: true,
                    //     searchable: true,
                    //     render: function(data, type, row, meta) {
                    //         return `
                //         <th scope="row">
                //             <div class="media align-items-center">
                //                 <div class="media-body">
                //                     <span class="mb-0 text-sm">${data}</span>
                //                 </div>
                //             </div>
                //         </th>`;
                    //     }
                    // },

                    // {
                    //     data: 'image',
                    //     name: 'image',
                    //     render: function(data, type, row, meta) {
                    //         return `
                //         <th scope="row">
                //         <div class="media align-items-center">
                //             <div class="media-body p-0 text-center">
                //                 <img src="${data}" alt="Product Image" width="100px" height="100px">
                //             </div>
                //         </div>
                //         </th>`;
                    //     }
                    // },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false,
                    //     render: function(data, type, row, meta) {
                    //         return `
                //         <th scope="row">
                //             <div class="media align-items-center">
                //                 <div class="media-body p-0 text-center">
                //                     <span class="mb-0 text-sm">${data}</span>
                //                 </div>
                //             </div>
                //         </th>`
                    //     }
                    // },
                ],
            });
        });

        function deleteConfirmation(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/dashboard/product/delete-" + id;
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
@endsection
