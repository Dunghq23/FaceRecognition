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
    {{-- @if (session('name'))
        
    @else
        <div class="d-flex align-items-center justify-content-center vh-100">
            @yield('content')
        </div>
    @endif --}}
    <main>
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
        <div class="container-fluid g-0">
            <div class="row g-0">
                <div class="col-md-2">
                    <nav class="vh-100" style="border-right: 1px solid rgb(224, 224, 224) !important;">
                        @include('layouts.sidebar')
                    </nav>
                </div>
                <div class="col-md-10">
                    <div class="content-wr er d-flex flex-column h-100">
                        <article class="flex-grow-1 px-3">
                            @yield('content')
                        </article>
                        <footer>
                            @include('layouts.footer')
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('general/js/libs/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('general/js/libs/jquery-3.7.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('general/js/libs/datetimepicker.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('general/js/tab-customize.js') }}"></script>
    @stack('javascript')
</body>

</html>
