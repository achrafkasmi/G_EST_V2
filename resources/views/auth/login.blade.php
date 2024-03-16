<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Login Page</title>
    <style>
        .main {
            height: 100%;
            min-height: 100vh;
            align-items: center;
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
                <div class="bg-light border py-3 px-4 rounded">

                    <form method="POST" action="{{ route('POST-CONNEXION') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email Universitaire">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Passcorde</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="APOGEE">
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

                                <!--@if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif-->
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


</body>

</html>