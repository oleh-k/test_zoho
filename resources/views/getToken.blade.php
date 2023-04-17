<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>getToken</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/js/app.js', 'resources/css/app.css'])
        
    </head>
    <body class="antialiased">

        <div id="app">
            
            <div class="parent-center">

                @if (Session::get('refresh_token') === null)
                    <get-token></get-token>
                @else
                    <p>
                        you already have token
                    </p>
                @endif
                
            </div>

        </div>


    </body>
</html>
