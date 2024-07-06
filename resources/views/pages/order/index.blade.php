@php
use Carbon\Carbon;
@endphp

@extends('layouts.app')
@section('title', 'Report')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Report</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Pesanan</li>
            </ol>
        </nav>
    </div>
</div>
<h5 class="mb-0 text-uppercase">Daftar laporan penjualan
    @if($selectedDate != '')
    {{ Carbon::parse($selectedDate)->translatedFormat('d F Y') }}
    @else
    {{ $formattedMonth }} {{ $selectedYear }}
    @endif
</h5>
<hr>
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-3">Cari Laporan Per Bulan</h5>
        <form class="row g-3 mb-4 ">
            <div class="col-md-4">
                <label for="input21" class="form-label">Bulan </label>
                <select id="input21" class="form-select" name="bulan">
                    @foreach ($monthNames as $month)
                    <option value="{{ $month }}" {{ $formattedMonth == $month ? 'selected' : '' }}>{{ $month }}</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-4">
                <label for="input21" class="form-label">Tahun </label>
                <select id="input21" class="form-select" name="tahun">
                    @foreach ($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-1"></div>
            <div class="col-md-3 align-self-end gap-2 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary"><i class='bx bx-search me-0'></i> Cari</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary"><i class='bx bx-refresh me-0'></i>
                    Refresh</a>
        </form>
        <form action="{{ route('orders.export') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="month">
            <input type="hidden" name="data" id="data">
            <input type="hidden" name="month" value="{{ $formattedMonth }} {{ $selectedYear }}">
            <button type="submit" class="btn btn-success"><i class='bx bxs-download me-0'></i> Excel</button>
        </form>
    </div>
    <h5 class="mb-3">Cari Laporan Per Hari</h5>
    <form class="row g-3 mb-4">
        <div class="col-md-8">
            <label for="input15" class="form-label">Tanggal</label>
            <div class="position-relative input-icon">
                <input type="date" class="form-control" id="input15" placeholder="Phone" name="tanggal"
                    value="{{ $selectedDate }}">
                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="col-md-3 align-self-end gap-2 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary"><i class='bx bx-search me-0'></i> Cari</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary"><i class='bx bx-refresh me-0'></i>
                Refresh</a>
    </form>
    <form action="{{ route('orders.export') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="daily">
        <input type="hidden" name="data" id="daily-data">
        <input type="hidden" name="month" value="{{ $selectedDate }}">
        <button type="submit" class="btn btn-success"><i class='bx bxs-download me-0'></i> Excel</button>
    </form>
</div>
<hr>
<div class="table-responsive">
    <table id="example" class="table table-hover " style="width:100%">
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
            @foreach ($orderDetails as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->product->code }}</td>
                <td>{{ $order->product->name }} {{ $order->variant ? '(' . $order->variant . ')' : '' }}</td>
                <td>{{ number_format($order->qty, 0, ',', '.') }}</td>
                @if ($order->product_details_id == null)
                <td>Rp. {{ number_format($order->product->buying_price, 0, ',', '.') }}</td>
                @else
                <td>Rp. {{ number_format($order->product_detail->buying_price, 0, ',', '.') }}</td>
                @endif
                <td>Rp. {{ number_format($order->total, 0, ',', '.') }}</td>
                <td>{{ $order->order->user->name }}</td>
                <td style="text-transform: capitalize">{{ $order->order->payment_method }}</td>
                <td>{{ Carbon::parse($order->created_at)->translatedFormat('d F Y, H:i') }}</td>
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
</div>
</div>

<script>
    document.getElementById('data').value = JSON.stringify(@json($orderDetails));
    document.getElementById('daily-data').value = JSON.stringify(@json($orderDetails));
</script>
@endsection
