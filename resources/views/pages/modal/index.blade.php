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
                <li class="breadcrumb-item active" aria-current="page">List Modal</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">List Modal</h6>
<hr />
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-hover " style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Kasir</th>
                        <th class="text-center">Modal Awal</th>
                        <th class="text-center">Total Pemasukan</th>
                        <th class="text-center">Total Pengeluaran</th>
                        <th class="text-center">Modal Akhir</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->user->name }}</td>
                        <td class="text-center">Rp. {{ number_format($data->total_modal, 0, ',', '.')}}</td>
                        <td class="text-center">Rp. {{ number_format($data->total_income, 0, ',', '.')}}</td>
                        <td class="text-center">Rp. {{ number_format($data->total_expense, 0, ',', '.')}}</td>
                        <td class="text-center">Rp. {{ number_format($data->final_modal, 0, ',', '.')}}</td>
                        <td class="text-center">
                            <a href="{{ route('modals.show', $data->id) }}" class="btn btn-outline-info"><i
                                    class='bx bx-show me-0'></i>
                            </a>
                            <a href="{{ route('modals.edit', $data->id) }}" class="btn btn-outline-warning"><i
                                    class='bx bx-edit me-0'></i>
                            </a>
                            <button onclick="confirmDelete({{ $data->id }})" type="button"
                                class="btn btn-outline-danger"><i class='bx bx-trash me-0'></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
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
