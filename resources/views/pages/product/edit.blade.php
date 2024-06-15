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

<a href="{{ route('products.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="row" id="productForm">
            @csrf
            @method('PUT')
            <!-- Form fields -->
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Kode Produk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="input35"
                        placeholder="Masukkan Kode Produk" autofocus name="code"
                        value="{{ old('code', $product->code) }}">
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
                        placeholder="Masukkan Nama Produk" name="name" value="{{ old('name', $product->name) }}">
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
                        placeholder="Masukkan Merk" name="brand" value="{{ old('brand' , $product->brand) }}">
                    @error('brand')
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
                        placeholder="Masukkan Diskon" name="discount" value="{{ old('discount', $product->discount) }}">
                    @error('discount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input39" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                    <select class="form-select @error('category_id') is-invalid @enderror" id="input39"
                        name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="buying" class="col-3 col-form-label">Pilih Opsi</label>
                <div class="col-9 row justify-content-center">
                    <div class="col-6 ">
                        <div id="hargaCard"
                            class="card card-option {{ count($product->productDetails) > 0 ? '' : 'card-selected' }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">Harga </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ">
                        <div id="variantCard"
                            class="card card-option {{ count($product->productDetails) > 0 ? 'card-selected' : '' }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">Varian </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="hargaDetail" class=""
                style="{{ count($product->productDetails) > 0 ? 'display: none;' : 'display: block;' }}">
                <div class="row mb-3">
                    <label for="buying" class="col-sm-3 col-form-label">Harga Jual</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('buying_price') is-invalid @enderror" id="buying"
                            placeholder="Masukkan Harga Jual" name="buying_price"
                            value="{{ old('buying_price', $product->buying_price) }}">
                        @error('buying_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="selling" class="col-sm-3 col-form-label">Harga Beli</label>
                    <div class="col-sm-9">
                        <input id="selling" type="text"
                            class="form-control @error('selling_price') is-invalid @enderror"
                            placeholder="Masukkan Harga Beli" name="selling_price"
                            value="{{ old('selling_price', $product->selling_price) }}">
                        @error('selling_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="input40" class="col-sm-3 col-form-label">Stok</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="input40"
                            placeholder="Masukkan Stok" name="stock" value="{{ old('stock', $product->stock) }}">
                        @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div id="variantDetail" class=""
                style="{{ count($product->productDetails) > 0 ? 'display: block;' : 'display: none;' }}">
                <div class="row mb-3">
                    <label for="variantSection" class="col-sm-3 col-form-label">Varian</label>
                    <div class="col-sm-9">
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="btn" style="background: #511f5a;color:white;"
                                id="addVariantBtn">Tambah
                                Variant</button>
                        </div>
                        <div class="table-responsive" id="variantTableWrapper">
                            <table class="table" id="variantTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Ukuran</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th style="width: 15%">Stok</th>
                                        <th style="width: 10%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Add variant rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden input for variants data -->
            <input type="hidden" name="variants_data" id="variantsData">
            <input type="hidden" name="selected_option" id="selectedOption" value="{{ count($product->productDetails) > 0 ?'variant' : 'harga' }}">

            <div class="row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .card-option {
        cursor: pointer;
        transition: transform 0.3s;
    }

    .card-option:hover {
        transform: scale(1.05);
    }

    .card-selected {
        border: 2px solid #511f5a;
    }
</style>
<script>
    const buyingPriceInput = document.getElementById('buying');
    const sellingPriceInput = document.getElementById('selling');
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    buyingPriceInput.value = formatRupiah('{{ $product->buying_price }}', 'Rp. ');
    sellingPriceInput.value = formatRupiah('{{ $product->selling_price }}', 'Rp. ');
    document.getElementById('hargaCard').addEventListener('click', function () {
        document.getElementById('hargaDetail').style.display = 'block';
        document.getElementById('variantDetail').style.display = 'none';
        this.classList.add('card-selected');
        document.getElementById('variantCard').classList.remove('card-selected');
        document.getElementById('selectedOption').value = 'harga';
    });

    document.getElementById('variantCard').addEventListener('click', function () {
        document.getElementById('hargaDetail').style.display = 'none';
        document.getElementById('variantDetail').style.display = 'block';
        this.classList.add('card-selected');
        document.getElementById('hargaCard').classList.remove('card-selected');
        document.getElementById('selectedOption').value = 'variant';
    });

    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route('product-detail.by-product', $product->id) }}')
            .then(response => response.json())
            .then(data => {
                const res = data.data;
                console.log(res);
                const variants = res.map(detail => ({
                    variant: detail.variant,
                    buying_price: detail.buying_price.toString(),
                    selling_price: detail.selling_price.toString(),
                    stock: detail.stock.toString(),
                    id: detail.id
                }));

                // Populate variants into form
                variants.forEach(variant => {
                    addVariant(variant);
                });
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
            });

        let variantIndex = 0;

        document.getElementById('addVariantBtn').addEventListener('click', function () {
            addVariant();
        });





        function addVariant(variantData = null) {
            variantIndex++;
            const variantTable = document.getElementById('variantTable').querySelector('tbody');

            const row = document.createElement('tr');
            row.classList.add('variant-item');
            row.innerHTML = `
                <td>
                    <input type="text" class="form-control" placeholder="Ukuran" name="variant${variantIndex}" value="${variantData ? variantData.variant : ''}" required>
                    <input type="hidden" name="id${variantIndex}" value="${variantData ? variantData.id : ''}">
                </td>
                <td>
                    <input type="text" class="form-control buying_price" placeholder="Harga Beli" name="buying_price${variantIndex}" value="${variantData ? formatRupiah(variantData.buying_price, 'Rp. ') : ''}" required>
                </td>
                <td>
                    <input type="text" class="form-control selling_price" placeholder="Harga Jual" name="selling_price${variantIndex}" value="${variantData ? formatRupiah(variantData.selling_price, 'Rp. ') : ''}" required>
                </td>
                <td>
                    <input type="number" class="form-control" placeholder="Stok" name="stock${variantIndex}" value="${variantData ? variantData.stock : ''}" required>
                </td>
                <td class="d-flex justify-content-center">
                    <button type="button" class="btn btn-danger  remove-variant-btn">
                        <i class='bx bx-trash me-0'></i></button>
                </td>
            `;

            variantTable.appendChild(row);

            row.querySelector('.remove-variant-btn').addEventListener('click', function () {
                row.remove();
                updateVariantIndices();
                // Check if there are any variants left
                if (variantTable.querySelectorAll('.variant-item').length === 0) {
                    document.getElementById('variantTableWrapper').style.display = 'none';
                }
            });

            row.querySelector('.buying_price').addEventListener('input', function (e) {
                e.target.value = formatRupiah(e.target.value, 'Rp. ');
            });

            row.querySelector('.selling_price').addEventListener('input', function (e) {
                e.target.value = formatRupiah(e.target.value, 'Rp. ');
            });

            // Show the table if it's hidden
            if (variantTable.querySelectorAll('.variant-item').length === 1) {
                document.getElementById('variantTableWrapper').style.display = 'block';
            }
        }

        function updateVariantIndices() {
            const variantItems = document.querySelectorAll('.variant-item');
            variantItems.forEach((variantItem, index) => {
                const inputs = variantItem.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/\d+/, index + 1);
                    input.setAttribute('name', newName);
                });
            });
        }

        document.getElementById('productForm').addEventListener('submit', function (e) {
            const variants = [];
            document.querySelectorAll('.variant-item').forEach(function (variantItem, index) {
                const variantInput = variantItem.querySelector(`input[name="variant${index + 1}"]`);
                const buyingPriceInput = variantItem.querySelector(`input[name="buying_price${index + 1}"]`);
                const sellingPriceInput = variantItem.querySelector(`input[name="selling_price${index + 1}"]`);
                const stockInput = variantItem.querySelector(`input[name="stock${index + 1}"]`);
                const idInput = variantItem.querySelector(`input[name="id${index + 1}"]`);

                if (variantInput.value && buyingPriceInput.value && sellingPriceInput.value && stockInput.value) {
                    const variantData = {
                        variant: variantInput.value,
                        buying_price: buyingPriceInput.value.replace(/[^,\d]/g, '').toString(),
                        selling_price: sellingPriceInput.value.replace(/[^,\d]/g, '').toString(),
                        stock: stockInput.value,
                        id: idInput.value
                    };
                    variants.push(variantData);
                }
            });

            document.getElementById('variantsData').value = JSON.stringify(variants);
        });

        // Initial check if there are any variants on page load
        document.addEventListener('DOMContentLoaded', function () {
            const variantTable = document.getElementById('variantTable');
            if (variantTable && variantTable.querySelectorAll('.variant-item').length > 0) {
                document.getElementById('variantTableWrapper').style.display = 'block';
            }
        });

        buyingPriceInput.addEventListener('input', function (e) {
        e.target.value = formatRupiah(e.target.value, 'Rp. ');
        });

        sellingPriceInput.addEventListener('input', function (e) {
        e.target.value = formatRupiah(e.target.value, 'Rp. ');
        });
    });
</script>
@endsection
