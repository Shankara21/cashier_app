@extends('layouts.app')

@section('title', 'Setting')

@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Manage Setting</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Setting</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Setting</h6>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('settings.update', $data->id) }}" method="POST" class="row">
            @method('PUT')
            @csrf
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name')
                                                                                    is-invalid
                                                                                    @enderror" id="input1"
                        placeholder="Name" name="name" required value="{{ old('name', $data->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Nomor Telpon</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('phone')
                                                                                    is-invalid
                                                                                    @enderror" id="input1"
                        placeholder="Phone" name="phone" required value="{{ old('phone', $data->phone) }}">
                    @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <textarea class="form-control" placeholder="Message" rows="3" cols="10" name="address">{{ old('address', $data->address) }}
                    </textarea>
                    @error('phone')
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