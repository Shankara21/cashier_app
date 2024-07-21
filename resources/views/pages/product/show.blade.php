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
                    <th>{{ $product->name }} </th>
                </tr>
                @if ($product->variant)
                <tr>
                    <td scope="row">Ukuran Produk</td>
                    <th>{{ $product->variant->name }} </th>
                </tr>
                @endif
                <tr>
                    <td scope="row">Merk</td>
                    <th>{{ $product->brand->name }}</th>
                </tr>
                <tr>
                    <td scope="row">Diskon</td>
                    <th>{{ $product->discount }}%</th>
                </tr>
                @if ($product->buying_price && $product->selling_price)
                <tr>
                    <td scope="row">Harga Beli</td>
                    <th>Rp. {{ number_format($product->buying_price, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <td scope="row">Harga Jual</td>
                    <th>Rp. {{ number_format($product->selling_price, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <td scope="row">Stok</td>
                    <th>{{ $product->stock ?? 0 }}</th>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection