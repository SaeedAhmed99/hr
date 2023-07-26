<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ setting('website_title') }} |
        {{ setting('company_title') ? setting('company_title') : config('app.name', 'Human Resource Management') }}
        - @yield('page-title')</title>

    <link rel="icon"
        href="{{ setting('company_favicon') && !empty(setting('company_favicon')) ? setting('company_favicon') : asset('storage/logo/CodeCloud_favicon.png') }}"
        type="image/x-icon" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

    <!-- Font Awesome -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="{{ asset('css/google-fonts.css') }}" rel="stylesheet" />
    <!-- bootstrap 5 -->
    <link href="{{ asset('css/bootstrap5.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/timepicker.css') }}">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />

    <!-- datatabel -->
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet" />
    <!-- datatabel -->
    {{-- <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/datatables.min.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ asset('css/apex-chart.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .toaster-z {
            z-index: 99999;
        }

        .sidebar-wrapper .company-logo {
            height: 45px;
            width: 45px !important;
        }

        .sidebar-wrapper .margin-top-10 {
            margin-top: 10px;
        }

        .sidebar-wrapper .margin-left-10 {
            margin-left: 10px;
        }

        .sidebar-wrapper #logout-form {
            display: none;
        }
    </style>
    @stack('head')
</head>

<body class="font-sans antialiased">
    {{-- <x-buy-now /> --}}

    <div class="min-h-screen bg-gray-100">
        <!-- Page Content -->
        @include('partial.sidebar')

        <div class="m-md-4 m-1">
            @yield('content')
        </div>

    </div>

    </div>
    @include('partial.footer')
    </div>

    <div class="position-fixed top-0 end-0 p-3 toaster-z">
        <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/bootstrap5.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>

    <!-- Datatable -->
    <script type="text/javascript" src="{{ asset('js/datatable/pdfmaker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatable/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatable/datatable.js') }}"></script>
    <!-- Datatable -->

    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-timepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/apexchart.js') }}"></script>
    <script type="text/javascript" src='{{ asset('js/fullcalendar.js') }}'></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/printThis.js') }}"></script>

    @if ($message = Session::get('success'))
        <script>
            show_toastr('Success', '{!! $message !!}', 'success');
        </script>
    @endif
    @if ($message = Session::get('error'))
        <script>
            show_toastr('Error', '{!! $message !!}', 'error');
        </script>
    @endif

    @stack('js')

    <script>
        $('.div-link').on('click', (e) => {
            <<
            <<
            <<
            <
            HEAD
                ===
                ===
                =
                console.log(e.currentTarget.dataset.link); >>>
            >>>
            >
            64 ba0a29a6099cafae207c0aaad88963dfd03040
            location.href = e.currentTarget.dataset.link;
        });

        // $('.announcement-div').on('mouseover', (e) => {
        //     if (!$('.announcement-div').hasClass('opened')) {
        //         $('.announcement-div').css('cursor', 'wait');
        //         setTimeout(() => {
        //             $('.announcement-div').addClass('opened');
        //             $('.announcement-div').css('cursor', 'default');
        //         }, 500);
        //     }
        // });

        // $('.announcement-div').on('mouseout', (e) => {
        //     $('.announcement-div').removeClass('opened');
        // });
    </script>

</body>

</html>
