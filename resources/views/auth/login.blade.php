<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login Page</title>
    <style>
        body {
            /*background-image: url('bglogin.PNG');  Specify the path to your background image */
            background-size: cover; /* Cover the entire body with the background image */
        }

        .main {
            height: 100%;
            min-height: 100vh;
            align-items: center;
        }

        /* Style the eye icon */
        .eye-icon {
            cursor: pointer;
            width: 24px;
            height: 24px;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-light bg-secondary">
    </nav>

    <div class="container">
        <div class="row main">
            <div class="col-lg-6">
                <img src="{{ asset('LogoEST.PNG') }}" class="img-fluid" width="70%" alt="Big Icon">
            </div>

            <div class="col-lg-6">
                <!-- Login Form -->
                <div class="bg-light border py-3 px-4">

                    <form method="POST" action="{{ route('POST-CONNEXION') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email Universitaire">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Passcode</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Passcode/APOGEE">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <img src="{{ asset('eye.png') }}" class="eye-icon" id="togglePassword" alt="Toggle Password Visibility">
                                    </span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">remember me</label>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <nav class="navbar navbar-light bg-secondary">
        <a class="navbar-brand text-light" href="#">
            <img src="{{ asset('LogoEST.PNG') }}" width="35" height="35" class="d-inline-block align-top" alt="">
            Ecole Supérieure de Technologie
        </a>
    </nav>

    <script>
        // Function to toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('exampleInputPassword1');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.src = type === 'password' ? '{{ asset("eye.png") }}' : '{{ asset("eyeclosed.png") }}';
        });
    </script>
</body>

</html>
