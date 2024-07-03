<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "PT Sans", sans-serif;
        }

        @page {
            size: 2.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;
        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        #logo {
            width: 60%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            padding: 5px;
            margin: 2px;
            display: block;
            margin: 0 auto;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top: 1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {
            content: "Rp";
            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }

        .total {
            font-size: 13px;
            border-top: 1px dashed black !important;
            border-bottom: 1px dashed black !important;
        }

        .total.text,
        .total.price {
            text-align: right;
        }

        .total.price::before {
            content: "Rp";
        }

        .line {
            border-top: 1px solid black !important;
        }

        .heading.rate {
            width: 20%;
        }

        .heading.amount {
            width: 25%;
        }

        .heading.qty {
            width: 5%;
        }

        p {
            padding: 1px;
            margin: 0;
        }

        section,
        footer {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <header>
        <!-- <div id="logo" class="media" data-src="logo.jpeg" src="./logo.jpeg"></div> -->
        <p style="font-size: 20px;font-weight: bolder">{{ $setting->name }}</p>
        <p style="font-size: 14px">{{ $setting->address  }}</p>

    </header>
    <table class="bill-details">
        <tbody>
            <tr>
                <td>Tanggal :</td>
                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td>Kasir :</td>
                <td>{{ $order->user->name }}</td>
            </tr>
            <tr>
                <td>Pembayaran : </td>
                <td>
                    @if ($order->payment_method == 'cash')
                    Tunai
                    @elseif ($order->payment_method == 'bca')
                    QRIS BCA
                    @elseif ($order->payment_method == 'bri')
                    QRIS BRI
                    @endif
                </td>
            </tr>
            <tr>
                <th class="center-align" colspan="2">
                    <span class="receipt">Daftar Belanja</span>
                </th>
            </tr>
        </tbody>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th class="heading name">Item</th>
                <th class="heading qty">Jumlah</th>
                <th class="heading amount">Harga</th>
                <th class="amount" style="color:white;">as</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->orderDetails as $item)
            <tr>
                <td>{{ $item->product->name }}
                    {{ $item->product->variant ? '(' . $item->product->variant->name . ')' : '' }}</td>
                <td>{{ $item->qty }}</td>
                <td class="price">{{ number_format($item->total, 0, ',', '.') }}</td>
                <td class="" style="color: white"> as</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" class="sum-up line">Sebelum Diskon</td>
                <td class="line price">{{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="sum-up">Diskon</td>
                <td class="price">{{ number_format($order->total_discount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="sum-up">Jumlah Bayar</td>
                <td class="price">{{ number_format($order->payment_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="2" class="total text">Kembalian</th>
                <th class="total price">{{ number_format($order->change, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="2" class="total text">Total</th>
                <th class="total price">{{ number_format($order->final_price, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    <section>
        <p style="text-align: center;font-size: 22px;">Thank you for your visit!</p>

    </section>
    <footer style="text-align: center;margin-top: 10px;">
        <div style="
          display: flex;
          justify-content: center;
          gap: 10px;
          margin-bottom: 5px;
          align-items: center;
        ">
            <img width="35px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Instagram_logo_2022.svg/1000px-Instagram_logo_2022.svg.png"
                alt="" />
            <p style="font-size: 14px;">NibrasHouse</p>
        </div>
        <div style="
          display: flex;
          justify-content: center;
          gap: 10px;
          margin-bottom: 5px;
          align-items: center;
        ">
            <img width="35px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Facebook_f_logo_%282019%29.svg/1280px-Facebook_f_logo_%282019%29.svg.png"
                alt="" />
            <p style="font-size: 14px;">NibrasHouse</p>
        </div>
        {{-- <p>{{ $setting->name }}</p>
        <p>www.dotworld.in</p> --}}
        <p>Tel: {{ $setting->phone  }}</p>
    </footer>
</body>

</html>
