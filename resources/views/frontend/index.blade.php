<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>frontend</title>

    <!-- Bootstrap CSS -->
    <link href="{{ url('frontend/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('frontend/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ url('frontend/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ url('frontend/css/overwrite.css') }}" />
    <link href="{{ url('frontend/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ url('frontend/css/style.css') }}" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    @livewireStyles
</head>
<body>
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    window.addEventListener('notify', event => {
        const type = event.detail.type;
        const message = event.detail.message;

        const commonOptions = {
            icon: type,
            title: type === 'success' ? 'Success' : 'Error',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'swal2-toast-custom'
            }
        };

        Swal.fire(commonOptions);
    });
</script>

<style>
    .swal2-toast-custom {
        font-weight: bolder;
        font-size: 16px;
    }
</style>

    <!-- jQuery and Bootstrap JS -->
    <script src="{{ url('frontend/js/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ url('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('frontend/js/parallax.min.js') }}"></script>
    <script src="{{ url('frontend/js/wow.min.js') }}"></script>
    <script src="{{ url('frontend/js/jquery.easing.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('frontend/js/fliplightbox.min.js') }}"></script>
    <script src="{{ url('frontend/js/functions.js') }}"></script>
    <script src="{{ url('frontend/contactform/contactform.js') }}"></script>

    @livewireScripts
</body>
</html>
