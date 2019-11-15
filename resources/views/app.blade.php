<!DOCTYPE html>
<html class="bg-gray-200">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
        <link href="{{ mix('/css/main.css') }}" rel="stylesheet">
        <link href="/css/fonts.css" rel="stylesheet">
        <script src="{{ mix('/js/main.js') }}" defer></script>
        @routes
    </head>

    <body class="font-ptsans leading-none text-gray-900 antialiased">
        <div id="app" data-page="{{ json_encode($page) }}" />
    </body>

</html>
