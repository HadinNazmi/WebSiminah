<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Bootstrap Input Validation</title>
</head>

<body>
    <div class="container mt-5">
        <form method="POST" action="{{ route('ceklogin') }}">
            @csrf
            <div class="col-md-12 mt-5 animate__animated animate__fadeInUp">
                <div class="inputContainer">
                    <i class="fa fa-briefcase icon"></i>
                    <input type="text" class="Field form-control is-valid" placeholder="Username"
                        name="username" required>
                </div>
            </div>

            <div class="col-md-12 mt-5 animate__animated animate__fadeInUp">
                <div class="inputContainer">
                    <i class="fa fa-lock icon"></i>
                    <input type="password" class="Field form-control" placeholder="Password"
                        name="password" required>
                </div>
            </div>
            <div class="col-md-12 mt-4 form-check animate__animated animate__fadeInUp">
                <input class="form-check-input" type="checkbox" value="" id="remember"
                    name="remember">
                <label class="form-check-label text-dark" for="remember">
                    Remember Me
                </label>
            </div>
            <div class="col-md-12 mt-4 animate__animated animate__fadeInUp login-bottom">
                <button type="submit" class="btn-custom btn-login">Sign in</button>
            </div>
        </form>
    </div>

    <script>
        // Get all the input elements with the "form-control" class
        var inputs = document.getElementsByClassName('form-control');

        // Loop through the input elements
        Array.prototype.forEach.call(inputs, function(input) {
            // Add an event listener to each input element
            input.addEventListener('input', function() {
                // Check if the input is valid
                if (input.checkValidity()) {
                    // Add the "is-valid" class and remove the "is-invalid" class
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                } else {
                    // Add the "is-invalid" class and remove the "is-valid" class
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
