@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Create Merk</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">List Merk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Merk</li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('brands.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('brands.update', $brand->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Merk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name')
                                                                            is-invalid
                                                                            @enderror" id="input1"
                        placeholder="Nama Kategori" name="name" required value="{{ old('name', $brand->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                    <select class="form-select @error('category_id') is-invalid @enderror" id="input39"
                        name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == $brand->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection