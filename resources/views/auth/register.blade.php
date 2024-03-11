@extends('master')

@section('app-mid')

<div class="app-main">
    <div class="container form-container bg-light-gray">
        <form action="{{ route('upload.post') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="form-title text-white">Add User</h2>
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end text-white">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end text-white">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end text-white">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end text-white">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="row mb-3">
                <label for="image" class="col-md-4 col-form-label text-md-end text-white">Upload image</label>

                <div class="col-md-6">
                    <input type="file" class="form-control" name="image" accept="image/*" required>
                </div>

            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    @media only screen and (max-width: 992px) {
        .form {
            background-color: rgba(255, 255, 255, 0.2);
            margin: 10px;
            width: 98%;
            position: absolute;
            left: 0;
        }
    }

    @media only screen and (min-width: 992px) {
        .form {
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0;
            width: 50%;
            position: absolute;
            left: 25%;
        }
    }

    /*.body{               hada old background momkin n7tajo
        background-image: url('background2.png'); 
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
    }*/

    .form-floatings {
        position: fixed;
        bottom: 0;
        width: 50%;
        transform: translateX(-50%);
    }

    .border {
        position: relative;
        border-radius: 20px;
    }
</style>


@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
