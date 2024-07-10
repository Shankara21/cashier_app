<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        table {
            width: 100vw;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #ffffff;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tfoot {
            background-color: #343a40;
            color: white;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .text-white {
            color: white !important;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Modal</th>
                <th>Total</th>
                <th>Kasir</th>
                <th>Pembayaran</th>
                <th>Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order['product']['code'] }}</td>
                <td>{{ $order['product']['name'] }} {{ isset($order['variant']) ? '(' . $order['variant'] . ')' : '' }}
                </td>
                <td>{{ number_format($order['qty'], 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($order['buying_price'], 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($order['total'], 0, ',', '.') }}</td>
                <td>{{ $order['order']['user']['name'] }}</td>
                <td style="text-transform: capitalize">{{ $order['order']['payment_method'] }}</td>
                <td>{{ Carbon\Carbon::parse($order['created_at'])->translatedFormat('d F Y, H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Terjual</th>
                <th>{{ number_format($orderAmount, 0, ',', '.') }}</th>
                <th>Rp. {{ number_format($capital, 0, ',', '.') }}</th>
                <th>Rp. {{ number_format($total, 0, ',', '.') }}</th>
                <th colspan="2" class="bg-success text-white text-center">Keuntungan</th>
                <th class="bg-success text-white">Rp. {{ number_format($profit, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
