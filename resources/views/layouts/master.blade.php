<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('general/images/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('general/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('general/fontawesome-free-6.4.0-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('general/css/master/main.css') }}">
    <link rel="stylesheet" href="{{ asset('general/css/master/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('general/css/master/header.css') }}">
    <link rel="stylesheet" href="{{ asset('general/css/datetimepicker.css') }}">
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('general/css/master/spinner.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&display=swap"
        rel="stylesheet">
    @stack('css')
</head>

<body>
    <main>
        {{-- Nếu có section `hideHeader`, không hiển thị header --}}
        @if (!View::hasSection('hideHeader'))
            <div class="container-fluid g-0">
                <div class="row g-0">
                    <div class="col-md-12">
                        <header>
                            @include('layouts.header')
                        </header>
                    </div>
                    <div class="col-md-12">
                        <div class="spacer"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="container-fluid g-0">
            <div class="row g-0">
                {{-- Nếu có section `hideSidebar`, không hiển thị sidebar --}}
                @if (!View::hasSection('hideSidebar'))
                    <div class="col-md-2">
                        <nav class="vh-100" style="border-right: 1px solid rgb(224, 224, 224) !important;">
                            @include('layouts.sidebar')
                        </nav>
                    </div>
                @endif

                <div class="{{ View::hasSection('hideSidebar') ? 'col-md-12' : 'col-md-10' }}">
                    <div class="content-wr er d-flex flex-column h-100">
                        <article class="flex-grow-1 px-3">
                            @yield('content')
                        </article>
                        {{-- Nếu có section `hideFooter`, không hiển thị footer --}}
                        @if (!View::hasSection('hideFooter'))
                            <footer>
                                @include('layouts.footer')
                            </footer>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('general/js/libs/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('general/js/libs/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('general/js/app.js') }}"></script>
    <script src="{{ asset('general/js/libs/sweetAlert.js') }}"></script>
    <script src="{{ asset('general/js/libs/datetimepicker.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('general/js/tab-customize.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successMessage = '{{ session('success') }}';
            let errorMessage = '{{ session('error') }}';
            let warningMessage = '{{ session('warning') }}';
            if (successMessage) {
                ShowToast('success', successMessage);
            } else if (errorMessage) {
                ShowToast('error', errorMessage);
            }
            else if (warningMessage) {
                ShowToast('warning', warningMessage);
            }
        });
    </script>

    @stack('javascript')
</body>

</html>
