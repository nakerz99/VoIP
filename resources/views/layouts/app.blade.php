<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
        
        <!-- Custom CSS for responsive sidebar -->
        <style>
            #sidebar {
                height: 100vh;
                position: fixed;
                transition: all 0.3s;
                z-index: 1000;
            }
            
            #content {
                transition: margin-left 0.3s;
            }
            
            /* Custom class for sidebar text visibility */
            .sidebar-text {
                display: none;
            }
            
            @media (min-width: 576px) {
                .sidebar-text {
                    display: inline;
                }
            }
            
            #sidebar.show .sidebar-text {
                display: inline !important;
            }
            
            @media (max-width: 767.98px) {
                #sidebar {
                    margin-left: -100%;
                    width: 250px;
                    position: fixed;
                }
                
                #sidebar.show {
                    margin-left: 0;
                }
                
                /* Show text labels when sidebar is toggled open on mobile */
                #sidebar.show .nav-link .d-none {
                    display: inline !important;
                }
                
                /* Also show text for other elements in the sidebar when open */
                #sidebar.show .d-none.d-sm-inline {
                    display: inline !important;
                }
                
                #content {
                    width: 100%;
                    margin-left: 0;
                }
                
                .overlay {
                    display: none;
                    position: fixed;
                    width: 100vw;
                    height: 100vh;
                    background: rgba(0, 0, 0, 0.7);
                    z-index: 998;
                    opacity: 0;
                    transition: all 0.5s ease-in-out;
                }
                
                .overlay.active {
                    display: block;
                    opacity: 1;
                }
            }
            
            @media (min-width: 768px) and (max-width: 1199.98px) {
                #sidebar {
                    width: 25%;
                }
                #content {
                    width: 75%;
                    margin-left: 25%;
                }
            }
            
            @media (min-width: 1200px) {
                #sidebar {
                    width: 16.66667%;
                }
                #content {
                    width: 83.33333%;
                    margin-left: 16.66667%;
                }
            }
        </style>
    </head>
    <body class="bg-light">
        <div class="min-vh-100">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="container-fluid py-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
