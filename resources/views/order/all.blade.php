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
        <div class="d-flex justify-between align-items-center  mb-3">
            <div class="card-header border-0 flex justify-between items-center">
                <h2 class="mb-0">Daftar Order</h2>
            </div>
            <div class="d-flex align-items-center">
                {{-- <div class="d-flex align-items-center"> --}}
                <input type="date" class="form-control mt-2" style="height: 20px; width: 15rem; padding: 1rem;"
                    placeholder="Tanggal Mulai" id="start_date" name="start_date">
                <label class="form-label ms-2 me-2">-</label>
                <input type="date" class="form-control mt-2" style="height: 20px; width: 15rem; padding: 1rem"
                    placeholder="Tanggal Selesai" id="end_date" name="end_date">
                {{-- </div> --}}
                <button type="button" class="btn btn-primary ml-2" style="background-color: blue"
                    id="filter">Filter</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="order-table" class="table align-items-center table-flush ">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" style="width: 10%">ID</th>
                        <th scope="col" style="width: 20%">KodeTransaksi</th>
                        <th scope="col" style="width: 20%">Customers</th>
                        <th scope="col" style="width: 20%">Total</th>
                        <th scope="col" style="width: 20%">Tanggal</th>
                        <th scope="col" style="width: 20%">Status</th>
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
                ajax: "{{ route('order.all') }}",
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
                        data: 'code_transfer',
                        name: 'code_transfer',
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
                        data: 'total',
                        name: 'total',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            const formattedData = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 2,
                            }).format(data);
                            return `
                            <th scope="row">
                                <div class="media align-items-end">
                                    <div class="media-body p-0">
                                        <span class="mb-0 text-sm">${formattedData}</span>
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

                            if (data === 'pending') {
                                backgroundColor = '#ff6c00';
                            } else if (data === 'success') {
                                backgroundColor = '#28a745';
                            } else if (data === 'failed') {
                                backgroundColor = '#dc3545';
                            }

                            return `
                            <th scope="row">
                                <div class="media align-items-end">
                                    <div class="media-body p-0">
                                        <span class="mb-0 text-sm" style="background-color: ${backgroundColor};padding: 5px 10px; display: inline-block;color:white;border-radius:50px">${data}</span>
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
            $('#filter').on('click', function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                table.clear()
                    .draw(); // Menghapus data saat ini dari tabel sebelum memuat data yang difilter
                table.ajax.url("{{ route('order.all') }}?start_date=" + startDate + "&end_date=" + endDate)
                    .load();
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
@endsection
