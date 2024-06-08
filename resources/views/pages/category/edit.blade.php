@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Edit Category</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">List Category</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav>
    </div>
</div>

<h6 class="mb-0 text-uppercase">Edit Category</h6>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6 mb-3">
                <label for="input1" class="form-label">Name</label>
                <input type="text" class="form-control @error('name')
                                                        is-invalid
                                                        @enderror" id="input1" placeholder="Name" name="name" required
                    value="{{ old('name', $category->name) }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
