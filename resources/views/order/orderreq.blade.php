<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
    </style>
    <div class="card shadow m-2 p-3">
        <div class="card-header border-0 flex justify-between items-center">
            <h3 class="mb-0">Daftar Request Order</h3>
            {{-- <a href="{{ route('cart.create') }}" class="btn btn-success ml-2 leading-2 px-3">+ Cart</a> --}}
            <a href="{{ route('orders.exportPdf') }}" class="btn btn-danger"> Export PDF
            </a>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible d-flex align-items-center fade show">
                <i class="bi-check-circle-fill"></i>
                <strong class="mx-2">Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show">
                <i class="bi-exclamation-octagon-fill"></i>
                <strong class="mx-2">Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table id="order-table" class="table align-items-center table-flush ">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" style="width: 10%">ID</th>
                        <th scope="col" style="width: 20%">Name Product</th>
                        <th scope="col" style="width: 15%">Customers</th>
                        <th scope="col" style="width: 15%">Jumlah</th>
                        <th scope="col" style="width: 15%">Tanggal</th>
                        <th scope="col" style="width: 15%">Status</th>
                        <th scope="col" style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            var table = $('#order-table').DataTable({
                ordering: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 500,
                pageLength: 5,
                pagingType: 'simple',
                lengthMenu: [5, 10, 25, 50, 100],
                ajax: "{{ route('order.reqOrder') }}",
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
                columns: [{
                        data: null,
                        "sortable": false,
                        "searchable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            return `
                        <th scope="row">
                            <div class="media align-items-end">
                                <div class="media-body p-0">
                                    <span class="mb-0 text-sm">${data}</span>
                                </div>
                            </div>
                        </th>`
                        }
                    },

                    {
                        data: 'username',
                        name: 'username',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `
                        <th scope="row">
                            <div class="media align-items-end">
                                <div class="media-body p-0">
                                    <span class="mb-0 text-sm">${data}</span>
                                </div>
                            </div>
                        </th>`
                        }
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            return `
                        <th scope="row">
                            <div class="media align-items-end">
                                <div class="media-body p-0">
                                    <span class="mb-0 text-sm">${data}</span>
                                </div>
                            </div>
                        </th>`
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            var date = new Date(data);

                            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei",
                                "Juni",
                                "Juli", "Agustus", "September", "Oktober", "November",
                                "Desember"
                            ];


                            var day = date.getDate();
                            var monthIndex = date.getMonth();
                            var year = date.getFullYear();


                            var formattedDate = day + ' ' + monthNames[monthIndex] + ' ' + year;

                            return `
                            <th scope="row">
                                <div class="media align-items-end">
                                    <div class="media-body p-0">
                                        <span class="mb-0 text-sm">${formattedDate}</span>
                                    </div>
                                </div>
                            </th>`;
                        }
                    },

                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let backgroundColor = '';
                            let displayText = '';

                            if (data === 'pending') {
                                backgroundColor = '#ff6c00';
                                displayText = 'Sedang Diproses';
                            } else if (data === 'success') {
                                backgroundColor = '#28a745';
                                displayText = 'Pembayaran Berhasil';
                            } else if (data === 'failed') {
                                backgroundColor = '#dc3545';
                                displayText = 'Pembayaran Gagal';
                            }

                            return `
                            <th scope="row">
                                <div class="media align-items-end">
                                    <div class="media-body p-0">
                                        <span class="mb-0 text-sm" style="background-color: ${backgroundColor};padding: 5px 10px; display: inline-block;color:white;border-radius:50px">${displayText}</span>
                                    </div>
                                </div>
                            </th>`;
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `
                        <th scope="row">
                            <div class="media align-items-end">
                                <div class="media-body p-0">
                                    <span class="mb-0 text-sm">${data}</span>
                                </div>
                            </div>
                        </th>`
                        }
                    },
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
                    window.location.href = "/dashboard/order/delete-" + id;
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
