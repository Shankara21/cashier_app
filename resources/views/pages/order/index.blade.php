@extends('layouts.app')
@section('title', 'Report')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Report</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Pesanan</li>
            </ol>
        </nav>
    </div>
</div>
<h5 class="mb-0 text-uppercase">Daftar laporan penjualan {{ $date }}</h5>
@endsection
