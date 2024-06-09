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
                        style="text-transform: capitalize">List product</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Create
                    product</li>
            </ol>
        </nav>
    </div>
</div>

<h6 class="mb-0 text-uppercase">Buat Data Baru product</h6>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" class="row" id="productForm">
            @csrf
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Code</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('code')
                    is-invalid
                    @enderror" id="input35" placeholder="Enter product code" autofocus name="code"
                        value="{{ old('code') }}">
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input36" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name')
                    is-invalid
                    @enderror" id="input36" placeholder="Product Name" name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input37" class="col-sm-3 col-form-label">Brand</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('brand')
                    is-invalid
                    @enderror" id="input37" placeholder="Product Brand" name="brand" value="{{ old('brand') }}">
                    @error('brand')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Buying Price</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control @error('buying_price')
                    is-invalid
                    @enderror" id="input38" placeholder="Product Buying Price" name="buying_price"
                        value="{{ old('buying_price') }}">
                    @error('buying_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Selling Price</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control @error('selling_price')
                    is-invalid
                    @enderror" id="input38" placeholder="Product Selling Price" name="selling_price"
                        value="{{ old('selling_price') }}">
                    @error('selling_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Stock</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control @error('stock')
                    is-invalid
                    @enderror" id="input38" placeholder="Product Stock" name="stock" value="{{ old('stock') }}">
                    @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Unit</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('unit')
                    is-invalid
                    @enderror" id="input38" placeholder="Product Unit" name="unit" value="{{ old('unit') }}">
                    @error('unit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input38" class="col-sm-3 col-form-label">Discount</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control @error('discount')
                    is-invalid
                    @enderror" id="input38" placeholder="Product Discount" name="discount"
                        value="{{ old('discount') }}">
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
                    <select class="form-select @error('category_id')
                    is-invalid
                    @enderror" id="input39" name="category_id">
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
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="button" class="btn btn-primary px-4"
                            onclick="document.getElementById('productForm').submit()">Submit</button>
                        <button type="reset" class="btn btn-light px-4">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection