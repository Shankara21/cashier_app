@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Edit {{ $user->roles[0]->name }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('users.index', ['role' => $user->roles[0]->name]) }}"
                        style="text-transform: capitalize">List {{ $user->roles[0]->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Edit
                    {{ $user->roles[0]->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('users.index', ['role' => $user->roles[0]->name]) }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="row">
            @method('PUT')
            @csrf
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name')
                                                                                        is-invalid
                                                                                        @enderror" id="input1"
                        placeholder="Name" name="name" required value="{{ old('name', $user->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control @error('email')
                                                                                        is-invalid
                                                                                        @enderror" id="input1"
                        placeholder="Email" name="email" required value="{{ old('email', $user->email) }}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                    <select id="role" class="form-select @error('role')
                                                                        is-invalid
                                                                    @enderror" name="role" name="role">
                        <option value="admin" {{ $user->roles[0]->name == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="cashier" {{ $user->roles[0]->name == 'cashier' ? 'selected' : '' }}>Cashier</option>
                    </select>
                    @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control @error('password')
                                                                                                is-invalid
                                                                                                @enderror"
                        id="password" placeholder="Password" name="password" required value="{{ old('password') }}">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control @error('confirm_password')
                                                                                                    is-invalid
                                                                                                    @enderror"
                        id="confirm_password" placeholder="Confirm Password" name="confirm_password" required
                        value="{{ old('password') }}">
                    @error('confirm_password')
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
