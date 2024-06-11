@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Create {{ $role ?? 'User' }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('users.index', ['role' => $role]) }}"
                        style="text-transform: capitalize">List {{ $role ?? 'User' }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">Create
                    {{ $role ?? 'User' }}</li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('users.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" class="row">
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
            <div class="col-4 mb-3">
                <label for="input1" class="form-label">Name</label>
                <input type="text" class="form-control @error('name')
                                                        is-invalid
                                                        @enderror" id="input1" placeholder="Name" name="name" required
                    value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-4 mb-3">
                <label for="input1" class="form-label">Email</label>
                <input type="email" class="form-control @error('email')
                                                        is-invalid
                                                        @enderror" id="input1" placeholder="Email" name="email"
                    required value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-4 mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" class="form-select @error('role')
                                        is-invalid
                                    @enderror" name="role" name="role">
                    <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ $role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                </select>
                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password')
                                                                    is-invalid
                                                                    @enderror" id="password" placeholder="Password"
                    name="password" required value="{{ old('password') }}">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-6 mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control @error('confirm_password')
                                                                    is-invalid
                                                                    @enderror" id="confirm_password"
                    placeholder="Confirm Password" name="confirm_password" required value="{{ old('password') }}">
                @error('confirm_password')
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
