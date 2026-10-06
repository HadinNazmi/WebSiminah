<!DOCTYPE html>
<html lang="en">

@include('components._partials.header')

<body class="login" data-mdb-animation-start="onLoad">
    <main class="main-content">
        <section class="login-page container-fluid">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-12 col-12 ps-4">
                    <div class="row mt-6 ps-4">
                        <div class="login-header">
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
                                <img class="navbar-brand-img" src="{{ asset('siminah-login.png') }}"
                                    alt="Logo pertamina">
                            </div>
                            <div
                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 text-poppins login-header-color">
                                <span class="siminah">Siminah</span>
                            </div>
                        </div>

                        <div class="login-body">
                            <div class="col-md-12 mt-6 ps-4 animate__animated animate__fadeInUp">
                                <h1 class="login-header-color .login-fs-header">Sign Into</h1>
                                <h4 class="mt-2 login-header-color .login-fs-subheader">Your Account</h6>
                            </div>
                        </div>

                        <div class="login-input">
                            <form class="was-validated" method="POST" action="{{ route('ceklogin') }}">
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
                                        <input type="password" class="Field form-control is-valid" placeholder="Password"
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
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-7 col-lg-6 col-md-5 bg-pertamina"
                    style="background-image: url('{{ asset('bg-pertamina.jpg') }}')">
                </div>
            </div>
        </section>
        
    </main>

    @include('components._partials.scripts')
</body>

</html>
