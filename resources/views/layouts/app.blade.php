<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WebService PlacetoPay - Redirección-Pago básico')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= url('/') ?>">
                PLACETOPAY
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/') ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/orders') ?>">Formulario Compra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/pagos-list') ?>">Pagos/Ordenes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/shoppingcart') ?>">Carrito Compra</a>
                    </li>
                </ul>
            </div>
        </nav><br />

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/popper-1.12.9.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/fasterjs.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('js') 
    <div class="modal" tabindex="-1" role="dialog" id="md-request">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Términos de la plataforma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearInterval(redirectionInterval);">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="
                        $('#timer').show();
                        $('#timer-desc').show();
                        var num = 5;
                        redirectionInterval = setInterval(function(){
                            if (num == 0)
                                $('#timer').text('...');
                            else
                                $('#timer').text(num.toString());
                            num--;
                            if (num < 0)
                                clearInterval(redirectionInterval);
                        }, 1000);
                        setTimeout(function(){
                            window.location = $('#timer-desc').attr('data-ref');
                        }, num * 1000);
                    ">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
