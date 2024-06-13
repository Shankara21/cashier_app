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

<a href="{{ route('products.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
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

            <!-- Variants Section -->
            <div class="row mb-3">
                <label for="variantSection" class="col-sm-3 col-form-label">Variant</label>
                <div class="col-sm-9">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" class="btn" style="background: #511f5a;color:white;"
                            id="addVariantBtn">Tambah Variant</button>
                    </div>
                    <div class="table-responsive" id="variantTableWrapper" style="display: none;">
                        <table class="table " id="variantTable">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Ukuran</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th style="width: 15%">Stok</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Hidden input for variants data -->
            <input type="hidden" name="variants_data" id="variantsData">

            <div class="row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                        {{-- <button type="reset" class="btn btn-light px-4">Reset</button> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    let variantIndex = 0;

    document.getElementById('addVariantBtn').addEventListener('click', function() {
        addVariant();
    });

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

    function addVariant() {
        variantIndex++;
        const variantTable = document.getElementById('variantTable').querySelector('tbody');

        const row = document.createElement('tr');
        row.classList.add('variant-item');
        row.innerHTML = `
            <td>
                <input type="text" class="form-control" placeholder="Ukuran" name="variant" required>
            </td>
            <td>
                <input type="text" class="form-control buying_price" placeholder="Harga Beli" name="buying_price" required>
            </td>
            <td>
                <input type="text" class="form-control selling_price" placeholder="Harga Jual" name="selling_price" required>
            </td>
            <td>
                <input type="number" class="form-control" placeholder="Stok" name="stock" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Hapus</button>
            </td>
        `;

        variantTable.appendChild(row);

        row.querySelector('.remove-variant-btn').addEventListener('click', function() {
            row.remove();
            // Check if there are any variants left
            if (variantTable.querySelectorAll('.variant-item').length === 0) {
                document.getElementById('variantTableWrapper').style.display = 'none';
            }
        });

        row.querySelector('.buying_price').addEventListener('input', function(e) {
            e.target.value = formatRupiah(e.target.value, 'Rp. ');
        });

        row.querySelector('.selling_price').addEventListener('input', function(e) {
                e.target.value = formatRupiah(e.target.value, 'Rp. ');
                });

                // Show the table if it's hidden
                if (variantTable.querySelectorAll('.variant-item').length === 1) {
                document.getElementById('variantTableWrapper').style.display = 'block';
                }
                }

                document.getElementById('productForm').addEventListener('submit', function(e) {
                const variants = [];
                document.querySelectorAll('.variant-item').forEach(function(variantItem) {
                const variantData = {
                variant: variantItem.querySelector('input[name="variant"]').value,
                buying_price: variantItem.querySelector('input[name="buying_price"]').value.replace(/[^,\d]/g, '').toString(),
                selling_price: variantItem.querySelector('input[name="selling_price"]').value.replace(/[^,\d]/g, '').toString(),
                stock: variantItem.querySelector('input[name="stock"]').value
                };
                variants.push(variantData);
                });

                document.getElementById('variantsData').value = JSON.stringify(variants);
                });

                // Initial check if there are any variants on page load
                document.addEventListener('DOMContentLoaded', function() {
                const variantTable = document.getElementById('variantTable');
                if (variantTable && variantTable.querySelectorAll('.variant-item').length > 0) {
                document.getElementById('variantTableWrapper').style.display = 'block';
                }
                });
                });
</script>
@endsection
