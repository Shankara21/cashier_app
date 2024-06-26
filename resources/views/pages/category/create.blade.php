@extends('layouts.app')
@section('title', 'Category')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Create Category</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">List Category</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Category</li>
            </ol>
        </nav>
    </div>
</div>

<a href="{{ route('categories.index') }}" class="btn btn-light"><i class="bx bx-arrow-back"></i> Kembali</a>
<hr />
<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Nama Kategori</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="input1"
                        placeholder="Nama Kategori" name="name" required value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="input35" class="col-sm-3 col-form-label">Variants</label>
                <div class="col-sm-9">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const variants = [];
        const variantInput = document.getElementById('variant-input');
        const variantsBadgeContainer = document.getElementById('variants-badge-container');
        const variantsHiddenInput = document.getElementById('variants-hidden-input');

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
    });
</script>
@endsection
