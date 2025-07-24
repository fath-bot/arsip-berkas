<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta property="og:title" content="@yield('title') - {{ config('app.name') }}" />
    <meta property="og:url" content="{{ route('home') }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <link rel="canonical" href="{{ route('home') }}" />
    <link rel="shortcut icon" href="{{ asset('ARSIP_KITA.ico') }}" />
    
    <title>@yield('title') - {{ config('app.name') }}</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('themes/admin/css/apps.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Push style tambahan dari view -->
    @stack('style')

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
