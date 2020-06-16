<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ (isset($title) ? $title . " - " . env('APP_NAME') : env('APP_NAME')) }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        @stack('css')
        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="app">
            @if (@$blank)
                @yield('content')
            @else
                <div id="wrapper">
                    <x-topbar :title="@$title" />
                    <x-sidebar />
                    <div class="content-page">
                        <div class="content">
                            <div class="container-fluid">
                                @yield('content')
                            </div>
                        </div>
                        <x-footer />
                    </div>
                </div>                
            @endif
        </div>

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>
        @stack('js')
        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
    </body>
</html>