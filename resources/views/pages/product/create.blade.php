@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Create product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}"
                        style="text-transform: capitalize">List product</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Create product
                </li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" class="row" id="productForm">
            @csrf
            <!-- Form fields -->
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Kode Produk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="input35"
                        placeholder="Masukkan Kode Produk" autofocus name="code" value="{{ old('code') }}">
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input36" class="col-sm-3 col-form-label">Nama Produk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="input36"
                        placeholder="Masukkan Nama Produk" name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input37" class="col-sm-3 col-form-label">Merk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('brand') is-invalid @enderror" id="input37"
                        placeholder="Masukkan Merk" name="brand" value="{{ old('brand') }}">
                    @error('brand')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="buyingPriceFormatted" class="col-sm-3 col-form-label">Harga Beli</label>
                <div class="col-sm-9">
                    <input type="hidden" name="buying_price" id="buyingPrice">
                    <input type="text" class="form-control @error('buying_price') is-invalid @enderror"
                        id="buyingPriceFormatted" placeholder="Masukkan Harga Beli" value="{{ old('buying_price') }}">
                    @error('buying_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="sellingPriceFormatted" class="col-sm-3 col-form-label">Harga Jual</label>
                <div class="col-sm-9">
                    <input type="hidden" name="selling_price" id="sellingPrice">
                    <input type="text" class="form-control @error('selling_price') is-invalid @enderror"
                        id="sellingPriceFormatted" placeholder="Masukkan Harga Jual" value="{{ old('selling_price') }}">
                    @error('selling_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="stockFormatted" class="col-sm-3 col-form-label">Stok</label>
                <div class="col-sm-9">
                    <input type="hidden" name="stock" id="stock">
                    <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stockFormatted"
                        placeholder="Masukkan Stok" value="{{ old('stock') }}">
                    @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Satuan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('unit') is-invalid @enderror" id="input38"
                        placeholder="Masukkan Satuan" name="unit" value="{{ old('unit') }}">
                    @error('unit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Diskon</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="input38"
                        placeholder="Masukkan Diskon" name="discount" value="{{ old('discount') }}">
                    @error('discount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input39" class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-9">
                    <select class="form-select @error('category_id') is-invalid @enderror" id="input39"
                        name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                        <button type="button" class="btn btn-primary px-4"
                            onclick="document.getElementById('productForm').submit()">Submit</button>
                        <button type="reset" class="btn btn-light px-4">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    function formatCurrency(value) {
        return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatNumber(value) {
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function handleInput(formattedInput, hiddenInput, formatter) {
        formattedInput.addEventListener('input', function() {
            let unformattedValue = formattedInput.value.replace(/[^,\d]/g, '');
            hiddenInput.value = unformattedValue;
            formattedInput.value = formatter(unformattedValue);
        });
    }

    let buyingPriceFormatted = document.getElementById('buyingPriceFormatted');
    let buyingPrice = document.getElementById('buyingPrice');
    handleInput(buyingPriceFormatted, buyingPrice, formatCurrency);

    let sellingPriceFormatted = document.getElementById('sellingPriceFormatted');
    let sellingPrice = document.getElementById('sellingPrice');
    handleInput(sellingPriceFormatted, sellingPrice, formatCurrency);

    let stockFormatted = document.getElementById('stockFormatted');
    let stock = document.getElementById('stock');
    handleInput(stockFormatted, stock, formatNumber);
});
</script>
@endsection
