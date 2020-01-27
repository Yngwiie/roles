<!doctype html>
    <html>
    <head>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <style>
        body{
            background: url('../img/nature1.jpg');
            background-repeat: no-repeat;
            background-size: auto;
            background-position:center center;
            background-attachment: fixed;
            height:100vh;
            width:100%;
        }
    
    </style>
    </head>
    <body>
    <div class="app">
       <header class="row">
       </header>
       <div id="main" class="row">
               @yield('content')
       </div>
       <footer class="row">
       </footer>
    </div>
    </body>
    </html>