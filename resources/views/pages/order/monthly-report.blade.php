<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Brand</th>
                <th scope="col">Kategori</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Diskon</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total</th>
                <th scope="col">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y') }}</td>
                <td>{{ $item['product']['name'] }} {{ $item['product']['variant']['name'] }}</td>
                <td>{{ $item['product']['brand']['name'] }}</td>
                <td>{{ $item['product']['category']['name'] }}</td>
                <td>Rp.{{ number_format($item['buying_price'], 0, ',', '.') }}</td>
                <td>Rp.{{ number_format($item['selling_price'], 0, ',', '.') }}</td>
                <td>{{ $item['discount'] }}%</td>
                <td>{{ $item['qty'] }}</td>
                <td>Rp.{{ number_format($item['total'], 0, ',', '.') }}</td>
                <td>
                    @if ($item['order']['payment_method'] == 'cash')
                    Tunai
                    @elseif ($item['order']['payment_method'] == 'bca')
                    QRIS BCA
                    @elseif ($item['order']['payment_method'] == 'mandiri')
                    QRIS MANDIRI
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Total Terjual</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Rp.{{ number_format($sum, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
