<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventVisiter Login Page</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap CDN -->
    <link
      {{-- href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet" --}}


    />
    <style>
        body {
            background: linear-gradient(to bottom right, #5de9e9, #976835);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .login-container .form-control {
            border-radius: 20px;
            padding: 3%;
            margin-top: 5%;
            width: 80%;
        }
        .login-container .btn {
            border-radius: 20px;
            background-color: #00bfa5;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            width: 80%;
        }
        .login-container .btn:hover {
            background-color: #00897b;
        }
        .remember-me {
            text-align: left;
            margin-top: 2%;
            margin-left: 8%;
            margin-bottom: 10px;
        }
        .login-footer a {
            text-decoration: none;
            color: #00bfa5;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .login-footer{
            margin-top: 5%;
            margin: 5%;

        }
        .login-footer a {
            text-decoration: none;
            color: #00bfa5;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .login-footer a {
            font-weight: bold;
            color: #00bfa5;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="mb-4">
            <img
              src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
              alt="Avatar"
              width="80"
            />
        </div>
        <h2 class="mb-4">Event Visitors Management</h2>
        <h3 class="fw-bold mb-3">Existing users, this way please!</h3>
            <div class="login-hint mb-4">
                <p>Login Your Account</p>
            </div>
        <form id="loginForm">
            @csrf
            <div class="mb-3 m-5">
                <input type="phone" class="form-control" placeholder="Existing User Name" id="phone" required />
            </div>
            <div class="mb-3 m-5">
                <input type="password" class="form-control" placeholder="Password" id="password" required />
            </div>
            <div class="remember-me mb-3">
                <input type="checkbox" id="rememberMe" />
                <label for="rememberMe">Remember me</label>
            </div>
            <button type="submit" class="btn w-100 mb-3">Login</button>
            <div class="login-footer mt-5">
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-link" style="background-color:#e54141; margin-right:25%;">Reset Password</a>
                    <a href="#" class="btn btn-link">Create Account</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Bind submit event to the form
        $(document).ready(function () {
            $('#loginForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                var phone = $('#phone').val();
                var password = $('#password').val();

                // AJAX request
                $.ajax({
                    url: "login",
                    type: "POST", // Corrected the typo
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        phone: phone,
                        password: password
                    },
                    success: function (response) {
                        // Handle success
                        // alert("Login successful: " + response.massage);
                        window.location.href = "{{ url( '/gettickets' )}}";
                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        alert("Error: " + xhr.responseText);
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>