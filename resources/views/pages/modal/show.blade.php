@extends('layouts.app')
@section('title', 'Modal')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Manage Modal</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Detail Modal</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Detail Modal</h6>
<hr />
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Nama Kasir : {{ $modal->user->name }}</h5>
        <div class="table-responsive">
            <table id="example" class="table table-hover " style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Invoice</th>
                        <th class="text-center">Jumlah</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($modal->modal_details as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->order->code }}</td>
                        <td class="text-center {{ $data->type == 'income' ? 'text-success' : 'text-danger' }}">Rp. {{ number_format($data->amount, 0, ',', '.')}}
                            @if ($data->type == 'income')
                            <span><i class='bx bx-trending-up text-success'></i></span>
                            @else
                            <span><i class='bx bx-trending-down text-danger'></i></span>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center">Modal Awal</td>
                        <th class="text-center bg-success text-white">Rp.
                            {{ number_format($modal->total_modal, 0, ',', '.')}}</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Modal Akhir</td>
                        <th class="text-center bg-success text-white">Rp.
                            {{ number_format($modal->final_modal, 0, ',', '.')}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<script>
    function confirmDelete(id) {
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#003285',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
    var form = document.getElementById('deleteForm');
    if (form) {
    form.action = '/modals/' + id;
    form.submit();
    } else {
    console.error("Form with ID 'deleteForm' not found.");
    }
    }
    });
    }
</script>
@endsection
