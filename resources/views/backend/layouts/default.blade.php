<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    @yield('head')

    <meta name="description" content=""/>

    <!-- select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/backend/img/favicon/favicon.ico')}}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/backend/vendor/fonts/boxicons.css')}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/backend/vendor/css/core.css')}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('assets/backend/vendor/css/theme-default.css')}}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset('assets/backend/css/demo.css')}}"/>



    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('assets/backend/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>

</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('backend.layouts.header')
        <div class="layout-page">

            @include('backend.layouts.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
            </div>
            @include('backend.layouts.footer')
        </div>
    </div>
</div>

</body>
</html>
