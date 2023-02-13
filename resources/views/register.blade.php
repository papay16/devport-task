@extends('layout.app')

@section('content')
    <main id="form-register" class="form-register w-100 m-auto">
        <form action="" method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Please register</h1>

            <div class="form-floating">
                <input type="text" class="form-control @error('username') is-invalid @enderror f_un" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                <label for="username">Username</label>
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="text" class="form-control @error('username') is-invalid @enderror f_pn" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
                <label for="phone_number">Phone Number</label>
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        </form>
    </main>
@endsection
