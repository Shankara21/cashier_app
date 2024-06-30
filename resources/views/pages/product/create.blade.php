@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Create product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
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
                <label for="input39" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                    <select class="form-select @error('category_id') is-invalid @enderror" id="input39"
                        name="category_id">
                        <option>Pilih Kategori</option>
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
            <div class="row mb-3">
                <label for="input37" class="col-sm-3 col-form-label">Merk</label>
                <div class="col-sm-9">
                    <select class="form-select @error('brand_id') is-invalid @enderror" id="input37" name="brand_id">
                    </select>
                    @error('brand_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Ukuran</label>
                <div class="col-sm-9 row" id="variantOptions">
                    <!-- Variants will be dynamically added here -->
                </div>
            </div>
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
                <label for="buying" class="col-sm-3 col-form-label">Harga Jual</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('buying_price') is-invalid @enderror" id="buying"
                        placeholder="Masukkan Harga Jual" name="buying_price" value="{{ old('buying_price') }}">
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
                    <input id="selling" type="text" class="form-control @error('selling_price') is-invalid @enderror"
                        placeholder="Masukkan Harga Beli" name="selling_price" value="{{ old('selling_price') }}">
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
                        placeholder="Masukkan Stok" name="stock" value="{{ old('stock') }}">
                    @error('stock')
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
                        <button type="button" class="btn btn-primary px-4" id="submitFormBtn">Submit</button>
                        {{-- <button type="reset" class="btn btn-light px-4">Reset</button> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function formatRupiah(angka, prefix) {
    // Filter hanya angka
    var number_string = angka.replace(/[^\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    document.getElementById('buying').addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value, 'Rp. ');
    });

    document.getElementById('selling').addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value, 'Rp. ');
    });

    $('#input39').on('change', function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: '/brands/category/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#input37').empty();
                    $.each(data.brands, function(key, value) {
                        $('#input37').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    // Handle variants
                    $('#variantOptions').empty();
                    if (data.variants && data.variants.length > 0) {
                        $.each(data.variants, function(key, variant) {
                            $('#variantOptions').append(
                                '<div class="col-1 mb-1">' +
                                    '<div class="form-check">' +
                                        '<input class="form-check-input" type="radio" name="variant_id" id="variant_' + variant.id + '" value="' + variant.id + '">' +
                                        '<label class="form-check-label" for="variant_' + variant.id + '">' + variant.name + '</label>' +
                                    '</div>' +
                                '</div>'
                            );
                        });
                    } else {
                        $('#variantOptions').append('<p>Kategori ini tidak memiliki ukuran</p>');
                    }
                }
            });
        } else {
            $('#input37').empty();
            $('#variantOptions').empty();
        }
    });

    // Submit form on button click
    $('#submitFormBtn').on('click', function() {
        $('#productForm').submit();
    });
</script>
@endsection