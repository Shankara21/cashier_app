@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Edit product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}"
                        style="text-transform: capitalize">List product</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Edit product
                </li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="row" id="productForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="hiddenBuyingPrice" name="buying_price">
            <input type="hidden" id="hiddenSellingPrice" name="selling_price">
            <input type="hidden" id="hiddenStock" name="stock">

            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Kode Produk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="input35"
                        placeholder="Masukkan Kode Produk" autofocus name="code"
                        value="{{ old('code', $product->code) }}">
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="input36" class="col-sm-3 col-form-label">Nama Produk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="input36"
                        placeholder="Masukkan Nama Produk" name="name" value="{{ old('name', $product->name) }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="input37" class="col-sm-3 col-form-label">Merk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('brand') is-invalid @enderror" id="input37"
                        placeholder="Masukkan Merk" name="brand" value="{{ old('brand', $product->brand) }}">
                    @error('brand')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="displayBuyingPrice" class="col-sm-3 col-form-label">Harga Beli</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('buying_price') is-invalid @enderror"
                        id="displayBuyingPrice" placeholder="Masukkan Harga Beli" name="display_buying_price"
                        value="{{ old('buying_price', $product->buying_price) }}">
                    @error('buying_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="displaySellingPrice" class="col-sm-3 col-form-label">Harga Jual</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('selling_price') is-invalid @enderror"
                        id="displaySellingPrice" placeholder="Masukkan Harga Jual" name="display_selling_price"
                        value="{{ old('selling_price', $product->selling_price) }}">
                    @error('selling_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="displayStock" class="col-sm-3 col-form-label">Stok</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('stock') is-invalid @enderror" id="displayStock"
                        placeholder="Masukkan Stok" name="display_stock" value="{{ old('stock', $product->stock) }}">
                    @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Satuan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('unit') is-invalid @enderror" id="input38"
                        placeholder="Masukkan Satuan" name="unit" value="{{ old('unit', $product->unit) }}">
                    @error('unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Diskon</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="input38"
                        placeholder="Masukkan Diskon" name="discount" value="{{ old('discount', $product->discount) }}">
                    @error('discount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="input39" class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-9">
                    <select class="form-select @error('category_id') is-invalid @enderror" id="input39"
                        name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                        <button type="button" class="btn btn-primary px-4" id="submitForm">Submit</button>
                        <button type="reset" class="btn btn-light px-4">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var displayBuyingPriceInput = document.getElementById('displayBuyingPrice');
        var displaySellingPriceInput = document.getElementById('displaySellingPrice');
        var displayStockInput = document.getElementById('displayStock');
        var hiddenBuyingPriceInput = document.getElementById('hiddenBuyingPrice');
        var hiddenSellingPriceInput = document.getElementById('hiddenSellingPrice');
        var hiddenStockInput = document.getElementById('hiddenStock');

        // Fungsi untuk mengonversi format mata uang menjadi integer
        function convertToInteger(currencyString) {
            return parseInt(currencyString.replace(/[^0-9]/g, ''));
        }

        // Fungsi untuk memformat angka sebagai mata uang Rupiah
        function formatCurrency(value) {
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Format nilai awal pada input saat halaman pertama kali dimuat
        displayBuyingPriceInput.value = formatCurrency(displayBuyingPriceInput.value);
        displaySellingPriceInput.value = formatCurrency(displaySellingPriceInput.value);
        displayStockInput.value = formatCurrency(displayStockInput.value);

        // Event listener untuk mengambil nilai dari input dan menyimpannya dalam input hidden
        displayBuyingPriceInput.addEventListener('input', function() {
            hiddenBuyingPriceInput.value = convertToInteger(displayBuyingPriceInput.value);
        });

        displaySellingPriceInput.addEventListener('input', function() {
            hiddenSellingPriceInput.value = convertToInteger(displaySellingPriceInput.value);
        });

        displayStockInput.addEventListener('input', function() {
            hiddenStockInput.value = convertToInteger(displayStockInput.value);
        });

        // Event listener untuk mengonversi nilai input ke format mata uang Rupiah saat diinput
        displayBuyingPriceInput.addEventListener('input', function() {
            var value = convertToInteger(displayBuyingPriceInput.value);
            displayBuyingPriceInput.value = formatCurrency(value);
        });

        displaySellingPriceInput.addEventListener('input', function() {
            var value = convertToInteger(displaySellingPriceInput.value);
            displaySellingPriceInput.value = formatCurrency(value);
        });

        displayStockInput.addEventListener('input', function() {
            var value = convertToInteger(displayStockInput.value);
            displayStockInput.value = formatCurrency(value);
        });

        // Submit form dengan hidden input yang sudah terisi nilai integer
        document.getElementById('submitForm').addEventListener('click', function() {
            hiddenBuyingPriceInput.value = convertToInteger(displayBuyingPriceInput.value);
            hiddenSellingPriceInput.value = convertToInteger(displaySellingPriceInput.value);
            hiddenStockInput.value = convertToInteger(displayStockInput.value);
            document.getElementById('productForm').submit();
        });
    });
</script>
@endsection
