@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Detail product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}"
                        style="text-transform: capitalize">List product</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Detail product
                </li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('products.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <h4>Detail Produk</h4>
        <table class="table mb-0 table-borderless w-50">
            <tbody>
                <tr>
                    <td scope="row">Kode Produk</td>
                    <th>{{ $product->code }}</th>
                </tr>
                <tr>
                    <td scope="row">Nama Produk</td>
                    <th>{{ $product->name }}</th>
                </tr>
                <tr>
                    <td scope="row">Merk</td>
                    <th>{{ $product->brand }}</th>
                </tr>
                <tr>
                    <td scope="row">Diskon</td>
                    <th>{{ $product->discount }}%</th>
                </tr>
            </tbody>
        </table>
        <hr>
        <h4>Daftar Ukuran</h4>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Ukuran</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Harga Jual</th>
                        <th class="text-center">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->productDetails as $item)
                    <tr>
                        <td class="text-center">{{ $item->variant }}</td>
                        <td class="text-center">Rp {{ number_format($item->buying_price, 0, ',', '.') }}</td>
                        <td class="text-center">Rp {{ number_format($item->selling_price, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($item->stock, 0, ',', '.') }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
