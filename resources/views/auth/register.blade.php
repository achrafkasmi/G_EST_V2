@extends('master')

@section('app-mid')
<title>Ajout d'Utilisateurs</title>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
        });
    </script>
@endif

<div class="app-main">
    @include('tiles.actions')
    <div class="containerf form-container bg-light-gray">
        <form id="user-form" action="{{ route('POST-USER-FORM') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="form-title text-white">Ajout d'Utilisateurs</h2>
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
                <label for="role" class="col-md-4 col-form-label text-md-end text-white">{{ __('Role') }}</label>
                <div class="col-md-6">
                    <select id="role" class="form-select" name="role" required>
                        <option value="">Selection de Rôle</option>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </select>
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
                    <button type="submit" id="user-submit-btn" class="btn btn-primary">{{ __('Register') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="containerf form-container">
        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="excelinput mb-5">
                <h2 class="form-title text-white">Addition Masse</h2>
                <input class="form-control" type="file" id="excel_file" name="excel_file">
                <button type="submit" id="excel-submit-btn" class="btn btn-primary mt-2">Go</button>
            </div>
        </form>
    </div>
</div>

<style>
    .containerf {
        background-color: #5e6a81;
        border-radius: 10px;
        margin: 5%;
        position: relative;
        padding: 5px;
    }

    .excelinput {
        width: 90%;
        margin: 0 auto;
        color: white;
    }

    @media only screen and (max-width: 768px) {
        .excelinput {
            width: 80%;
            margin-left: 10%;
        }
    }

    @media only screen and (max-width: 480px) {
        .excelinput {
            width: 90%;
            margin-left: 5%;
        }
    }

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.getElementById('user-form').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password-confirm').value;

        if (password.length < 8) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Password must be at least 8 characters long!',
            });
            return;
        }

        if (password !== confirmPassword) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Passwords do not match!',
            });
        }
    });
</script>

@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
