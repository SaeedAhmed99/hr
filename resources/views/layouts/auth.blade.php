<!DOCTYPE html>
<html lang="en">

<head>

    {{-- <title>{{(Utility::getValByName('header_text')) ? Utility::getValByName('header_text') : config('app.name', 'LeadGo')}} &dash; @yield('title')</title> --}}
    {{--  <title>
        {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'HRMGo') }}
        - @yield('page-title')</title>  --}}
    <title>
        {{ setting('website_title') }} |
        {{ setting('company_title') ? setting('company_title') : config('app.name', 'Human Resource Management') }}
        - @yield('page-title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <link rel="icon" href="{{ asset('storage/logo/logo.png') }}" type="image/x-icon" />

    <!-- Favicon icon -->
    <link rel="icon"
        href="{{ setting('company_favicon') && !empty(setting('company_favicon')) ? setting('company_favicon') : asset('storage/logo/CodeCloud_favicon.png') }}"
        type="image/x-icon" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" type="image/x-icon" />
    <style>
        .wrapper-width {
            width: 100%;
        }
    </style>
    @stack('css')
</head>

<body class="overflow-hidden">
    <!-- [ auth-signup ] start -->
    <div class="wrapper wrapper-width">
        <div class="content">
            <div class="card">
                @yield('content')
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- [ auth-signup ] end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4="
        crossorigin="anonymous"></script>

    {{--  <input type="checkbox" class="d-none" id="cust-theme-bg"
        {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }} />
    <input type="checkbox" class="d-none" id="cust-darklayout"
        {{ Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : '' }} />  --}}

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
</body>

</html>
