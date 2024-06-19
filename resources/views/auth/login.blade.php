<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login Page</title>
    <style>
        body {
            background: radial-gradient(circle, rgba(5, 19, 64, 1) 1%, rgba(4, 15, 50, 1) 100%);
            background-size: cover;
            color: #fff;
            overflow: hidden;
        }

        .main {
            height: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo-container {
            position: absolute;
            width: 70%;
            max-width: 350px;
            display: flex;
            justify-content: center;
            animation: fadeInBlur 2s forwards, slideLeft 2s forwards 1.5s;
        }

        @keyframes fadeInBlur {
            0% {
                opacity: 0;
                filter: blur(10px);
            }
            100% {
                opacity: 1;
                filter: blur(0);
            }
        }

        @keyframes slideLeft {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-130% + 80px));
            }
        }

        .credentials-container {
            background: rgba(128, 128, 128, 0.8);
            border-radius: 15px;
            opacity: 0;
            animation: fadeIn 1s forwards 3s;
            max-width: 600px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .navbar-light .navbar-brand {
            color: #fff;
        }

        .form-check-label {
            color: #01081f;
        }

        .form-group label {
            color: #01081f;
        }

        .eye-icon {
            cursor: pointer;
            width: 24px;
            height: 24px;
            background-size: cover;
            background-repeat: no-repeat;
        }

        /* Media query for phones */
        @media (max-width: 576px) {
            .logo-container {
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                max-width: 120px; /* Reduce the size */
                animation: fadeInBlur 2s forwards, slideUp 1.5s forwards 2s;
            }

            @keyframes slideUp {
                0% {
                    transform: translate(-50%, -50%);
                }
                100% {
                    transform: translate(-50%, -300%);
                }
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row main">
            <div class="logo-container">
                <img src="{{ asset('LogoEST.PNG') }}" class="img-fluid" width="100%" alt="Big Icon">
            </div>

            <div class="col-lg-6 offset-lg-6">
                <!-- Login Form -->
                <div class="credentials-container py-3 px-4">
                    <form method="POST" action="{{ route('POST-CONNEXION') }}" id="loginForm">
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

                        <div class="alert alert-danger mt-3 d-none" id="errorAlert">
                            Incorrect credentials, please try again.
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        // password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('exampleInputPassword1');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.src = type === 'password' ? '{{ asset("eye.png") }}' : '{{ asset("eyeclosed.png") }}';
        });

        // handle form submission
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Clear any previous error message
            document.getElementById('errorAlert').classList.add('d-none');

            // Get the form data
            const email = document.getElementById('email').value;
            const password = document.getElementById('exampleInputPassword1').value;
            const remember = document.getElementById('remember').checked;
            
            // Send the form data using AJAX
            fetch('{{ route('POST-CONNEXION') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ email, password, remember })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Invalid credentials.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Redirect to dashboard or appropriate page
                    window.location.href = '/dash';
                } else {
                    throw new Error(data.message || 'Invalid credentials.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message and clear input fields
                document.getElementById('errorAlert').textContent = error.message;
                document.getElementById('errorAlert').classList.remove('d-none');
                document.getElementById('email').value = '';
                document.getElementById('exampleInputPassword1').value = '';
            });
        });
    </script>
</body>

</html>
