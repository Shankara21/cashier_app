@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Edit Category</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">List Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('categories.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Nama Kategori</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="input1"
                        placeholder="Name" name="name" required value="{{ old('name', $category->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Variant</label>
                <div class="col-sm-9">
                    <div class="table-responsive mb-3">
                        <table id="example" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Variant</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($category->variants as $var)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $var->name }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-warning" data-id="{{ $var->id }}"
                                            data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal"><i
                                                class='bx bx-edit me-0'></i></button>
                                        <button onclick="confirmDelete({{ $var->id }})" type="button"
                                            class="btn btn-outline-danger"><i class='bx bx-trash me-0'></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada variant</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" id="variant-input" class="form-control" placeholder="Variant">
                        <button type="button" id="add-variant-btn" class="btn btn-success">Tambah Variant</button>
                    </div>
                    <div id="variants-badge-container">
                        <!-- Badges will be displayed here -->
                    </div>
                </div>
            </div>
            <input type="hidden" name="variants" id="variants-hidden-input" value="">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="edit-variant-form" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="modal-variant-name" class="col-sm-3 col-form-label">Variant</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="modal-variant-name" placeholder="Nama Variant" name="name" required value="">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
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
                    form.action = '/variants/' + id;
                    form.submit();
                } else {
                    console.error("Form with ID 'deleteForm' not found.");
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const variants = [];
        const variantInput = document.getElementById('variant-input');
        const variantsBadgeContainer = document.getElementById('variants-badge-container');
        const variantsHiddenInput = document.getElementById('variants-hidden-input');
        const modalVariantName = document.getElementById('modal-variant-name');
        const editVariantForm = document.getElementById('edit-variant-form');

        document.getElementById('add-variant-btn').addEventListener('click', function () {
            const variant = variantInput.value.trim();
            if (variant && !variants.includes(variant)) {
                variants.push(variant);
                updateVariantsDisplay();
                variantInput.value = '';
            }
        });

        variantsBadgeContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-variant-btn')) {
                const variant = e.target.dataset.variant;
                const index = variants.indexOf(variant);
                if (index > -1) {
                    variants.splice(index, 1);
                    updateVariantsDisplay();
                }
            }
        });

        function updateVariantsDisplay() {
            variantsBadgeContainer.innerHTML = '';
            variants.forEach(variant => {
                const badge = document.createElement('span');
                badge.classList.add('badge', 'bg-info', 'me-2');
                badge.innerHTML = `${variant} <button type="button" class="btn btn-danger btn-sm remove-variant-btn" style="margin-left: 5px" data-variant="${variant}">x</button>`;
                variantsBadgeContainer.appendChild(badge);
            });
            variantsHiddenInput.value = JSON.stringify(variants);
        }

        // Fetch variant data on edit button click
        document.querySelectorAll('.btn-outline-warning').forEach(button => {
            button.addEventListener('click', function () {
                const variantId = this.getAttribute('data-id');
                fetch(`/variants/${variantId}`)
                    .then(response => response.json())
                    .then(data => {
                        modalVariantName.value = data.name;
                        editVariantForm.action = `/variants/${variantId}`;
                    })
                    .catch(error => console.error('Error fetching variant data:', error));
            });
        });

        document.getElementById('save-variant-changes').addEventListener('click', function () {
            // Implement save changes functionality
            // This would typically involve making an AJAX request to update the variant on the server
        });
    });
</script>
@endsection
