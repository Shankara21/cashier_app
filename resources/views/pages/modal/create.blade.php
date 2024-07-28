@extends('layouts.app')
@section('title', 'Modal')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Create Modal</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('modals.index') }}">List Modal</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Modal</li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('modals.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('modals.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Nama Kasir</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control d-none" id="input1" placeholder="" name="user_id" required
                        value="{{ auth()->user()->id }}">
                    <input type="text" class="form-control" id="input1" placeholder="" disabled required
                        value="{{ auth()->user()->name }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="selling" class="col-sm-3 col-form-label">Modal Hari Ini</label>
                <div class="col-sm-9">
                    <input id="selling" type="text" class="form-control @error('total_modal') is-invalid @enderror"
                        placeholder="Masukkan Modal Hari Ini" name="total_modal" value="{{ old('total_modal') }}">
                    @error('total_modal')
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

<script>
    document.getElementById('selling').addEventListener('keyup', function(e) {
    this.value = formatRupiah(this.value, 'Rp. ');
    });

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
</script>
@endsection
