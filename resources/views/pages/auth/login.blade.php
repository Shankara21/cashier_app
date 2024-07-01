@extends('components.layouts.auth')
@section('title', 'Login')
@section('content')
<div class="container ">
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
        <div class="col mx-auto">
            <div class="card mb-0" style="background: #ec1271;color:white;">
                <div class="card-body">
                    <div class="p-4">
                        <div class="mb-3 text-center">
                            <img src="/assets/images/logo-nibras.png" width="130" alt="" />
                        </div>
                        <div class="text-center mb-4">
                            <h5 class="text-white">Kasir Nibras House Wungu</h5>
                            <p class="mb-0">Silahkan masuk untuk melanjutkan.</p>
                        </div>
                        <div class="form-body">
                            <form class="row g-3" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email')
                                        is-invalid
                                    @enderror" id="inputEmailAddress" placeholder="Masukkan Alamat Email" name="email"
                                        value="{{ old('email') }}">

                                    @error('email')
                                    <span class="invalid-feedback text-white" role="alert">
                                        <strong>*{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="inputChoosePassword" class="form-label">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control border-end-0 @error('password')
is-invalid
                                        @enderror" id="inputChoosePassword" placeholder="Masukkan Password"
                                            name="password"> <a href="javascript:;"
                                            class="input-group-text bg-transparent text-white"><i class='bx bx-hide'></i></a>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn " style="background: #FFBF00">Masuk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</div>
@endsection
