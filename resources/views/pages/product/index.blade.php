@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3" style="text-transform: capitalize">Manage Product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">List Product
                </li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Buat Data Baru</a>
        </div>
    </div>
</div>

<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">List Product</h6>
<hr />
<div class="card">
    <div class="card-body">
        <form id="filterForm" action="{{ route('products.index') }}" method="GET">
            <div class="d-flex mb-3 gap-3 w-75">
                <div class="col-4">
                    <label for="select-category" class="form-label">Kategori</label>
                    <select id="select-category" class="form-select" name="category" onchange="fetchBrands(this.value)">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label for="select-brand" class="form-label">Brand</label>
                    <select id="select-brand" class="form-select" name="brand" onchange="submitForm()">
                        <option value="">Pilih Brand</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table id="example" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Merk</th>
                        <th class="text-center">Diskon</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->code }}</td>
                        <td class="text-center">{{ $data->name }} {{ $data->variant ? '(' . $data->variant->name . ')' : '' }}
                        </td>
                        <td class="text-center">{{ $data->brand->name }}</td>
                        <td class="text-center">{{ $data->discount }}%</td>
                        <td class="text-center">{{ $data->category->name }}</td>
                        <td class="text-center">{{ $data->stock }}</td>
                        <td class="text-center">
                            <a href="{{ route('products.show', $data->id) }}" class="btn btn-outline-info"><i
                                    class='bx bx-show me-0'></i></a>
                            <a href="{{ route('products.edit', $data->id) }}" class="btn btn-outline-warning"><i
                                    class='bx bx-edit me-0'></i></a>
                            <button onclick="confirmDelete({{ $data->id }})" type="button"
                                class="btn btn-outline-danger"><i class='bx bx-trash me-0'></i></button>
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
                    form.action = '/products/' + id;
                    form.submit();
                } else {
                    console.error("Form with ID 'deleteForm' not found.");
                }
            }
        });
    }

    function fetchBrands(categoryId) {
        if (categoryId) {
            $.ajax({
                url: '/brands/category/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var brands = data.brands;
                    var selectedBrand = "{{ request('brand') }}";
                    $('#select-brand').empty();
                    $('#select-brand').append('<option value="">Pilih Brand</option>');
                    $.each(brands, function(key, value) {
                        $('#select-brand').append('<option value="' + value.id + '"' + (selectedBrand == value.id ? ' selected' : '') + '>' + value.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching brands:', error);
                }
            });
        } else {
            $('#select-brand').empty();
            $('#select-brand').append('<option value="">Pilih Brand</option>');
        }
    }

    function submitForm() {
        document.getElementById('filterForm').submit();
    }

    // Initialize brands on page load if a category is already selected
    document.addEventListener('DOMContentLoaded', function() {
        var selectedCategory = document.getElementById('select-category').value;
        if (selectedCategory) {
            fetchBrands(selectedCategory);
        }
    });
</script>
@endsection
