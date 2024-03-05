<!DOCTYPE html>
<html>

<head>
    <title>Sukses Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-success {
            color: green;
        }
    </style>
</head>

<body>
    <h1>Daftar Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Nama Customer</th>
                <th>Nama Product</th>
                <th>Jumlah</th>
                <th>Total Order</th>
                <th>Tanggal Order</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pdfData as $data)
                <tr>
                    <td>{{ substr($data['code_transfer'], -6) }}</td>
                    <td>{{ $data['customer'] }}</td>
                    <td>{{ $data['product'] }}</td>
                    <td>{{ $data['qty'] }}</td>
                    <td>Rp{{ number_format($data['total'], 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
                    <td class="status-success">
                        Berhasil
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
