<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ getTitle() }}
        <link rel="shortcut icon" type="image/png" href="{{ url('img/favicon.ico') }}">
        {{ stylesheet_link('css/bootstrap.min.css') }}
        {{ stylesheet_link('css/brain-theme.css') }}
        {{ stylesheet_link('css/styles.css') }}
        {{ stylesheet_link('css/font-awesome.min.css') }}
        {{ stylesheet_link("http://fonts.googleapis.com/css?family=Cuprum", false) }}
        {{ javascript_include('js/jquery.min.js') }}
        {{ javascript_include('js/jquery-ui.min.js') }}
        {{ javascript_include('js/plugins/interface/collapsible.min.js') }}
        {{ javascript_include('js/bootstrap.min.js') }}
        {{ javascript_include('js/application_blank.js') }}
    </head>
    <body>
        {{ content() }}
    </body>
</html>
