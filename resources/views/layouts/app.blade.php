<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body class="bg-login">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top custom-navbar">
        <div class="container">
            <a class="navbar-brand fs-6 fs-sm-5 fs-md-4 fs-lg-2 text-uppercase" href="{{ url('/') }}">Tempahan Meja Malam Gala</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="{{ route('login') }}">Log Masuk Admin</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <form action="{{ route('home') }}" method="get" class="d-inline">
                            <button type="submit" class="nav-link btn btn-link text-uppercase">Dashboard</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                            {{ csrf_field() }}
                            <button type="submit" class="nav-link btn btn-link text-uppercase">Log Keluar</button>
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!--wrapper-->
    @if (session('success'))
    <div id="floating-success-message" class="position-fixed top-0 start-50 translate-middle-x p-3">
        <div class="alert alert-success alert-dismissible fade show bg-light bg-opacity-75" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <!-- JavaScript to show the message after the page is loaded -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var floatingMessage = document.getElementById('floating-success-message');
            floatingMessage.style.display = 'block';
            setTimeout(function() {
                floatingMessage.style.display = 'none';
            }, 4500); // Adjust the timeout (in milliseconds) based on how long you want the message to be visible
        });
    </script>
    @endif

    @yield('content')
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });

        $("#show_hide_password_confirm a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password_confirm input').attr("type") == "text") {
                $('#show_hide_password_confirm input').attr('type', 'password');
                $('#show_hide_password_confirm i').addClass("bx-hide");
                $('#show_hide_password_confirm i').removeClass("bx-show");
            } else if ($('#show_hide_password_confirm input').attr("type") == "password") {
                $('#show_hide_password_confirm input').attr('type', 'text');
                $('#show_hide_password_confirm i').removeClass("bx-hide");
                $('#show_hide_password_confirm i').addClass("bx-show");
            }
        });
    </script>
     <script>
        // Get the current year
        var currentYear = new Date().getFullYear();

        // Update the content of the element with the current year
        document.getElementById("copyright").innerHTML = 'Copyright © ' + currentYear +
            ' <a href="https://sarawak.uitm.edu.my/" target="_blank">UiTM Cawangan Sarawak</a>.';
    </script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>