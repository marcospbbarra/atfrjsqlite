<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Formulário') — ATFRJ</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(160deg, #e8f2ef 0%, #f5ede4 100%);
            color: #1f2937;
        }

        .form-shell {
            min-height: 100vh;
        }

        .form-card {
            border: 0;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 1.5rem 4rem rgba(15, 23, 42, 0.14);
        }

        .form-aside {
            background: linear-gradient(160deg, #3e8a7b 0%, #1a4a3f 60%, #152f2a 100%);
            color: #f0f7f5;
        }

        .logo-box {
            background: rgba(255, 255, 255, 0.94);
            border-radius: 1.5rem;
            display: inline-flex;
            padding: 1rem 1.25rem;
        }

        .logo-box img {
            display: block;
            height: 72px;
            width: auto;
        }

        .feature-tile {
            border-radius: 1.25rem;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(200, 240, 220, 0.18);
        }

        .aside-accent {
            color: #f5b07a;
        }

        .form-panel {
            background: rgba(255, 255, 255, 0.96);
        }

        .form-control,
        .form-check-input,
        .btn {
            border-radius: 1rem;
        }

        .checkbox-card {
            border: 1px solid #dee2e6;
            border-radius: 1.25rem;
            background: #fff;
        }

        .btn-brand {
            background-color: #c8622a;
            border-color: #c8622a;
            color: #fff;
        }

        .btn-brand:hover {
            background-color: #a8501e;
            border-color: #a8501e;
            color: #fff;
        }

        @media (max-width: 991.98px) {
            .logo-box img {
                height: 60px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <main class="form-shell d-flex align-items-center py-4 py-lg-5">
        <div class="container">
            <div class="card form-card">
                <div class="row g-0">

                    {{-- Barra lateral esquerda --}}
                    <div class="col-lg-4 form-aside p-4 p-xl-5">
                        <div class="h-100 d-flex flex-column justify-content-between gap-4">
                            <div>
                                <div class="logo-box shadow-sm mb-4">
                                    <img src="{{ asset('imgs/logo2.webp') }}" alt="ATFRJ">
                                </div>

                                @yield('aside')
                            </div>

                            @hasSection('aside-tiles')
                                <div class="row g-3">
                                    @yield('aside-tiles')
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Painel do formulário --}}
                    <div class="col-lg-8 form-panel p-4 p-xl-5">
                        @yield('content')
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>
