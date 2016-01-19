<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        {#Especificacion del tamaño de pantalla +#}
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        {{ getTitle() }}
        <link rel="shortcut icon" type="image/png" href="{{ url('favicon.ico') }}">
        {#Archivos Globales#}
        {#Plugin PhalconJquery
        {{jquery}}
        #}
        {# jQuery 2.1.4 #}
        {{ javascript_include('plugins/jQuery/jQuery-2.1.4.min.js') }}
        {# Bootstrap 3.3.5 #}
        {{ stylesheet_link('bootstrap/css/bootstrap.min.css') }}
        {#  Font Awesome
        {{ stylesheet_link("https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css", false) }}#}
        {{ stylesheet_link("fonts/css/font-awesome.min.css" ) }}
        {#  Ionicons #}
        {{ stylesheet_link("css/ionicons.min.css") }}
        {{ stylesheet_link("css/calculadora.css") }}
        {# Template de Estilo#}
        {{ stylesheet_link('dist/css/AdminLTE.min.css') }}
        {# Skins Colors#}
        {{ stylesheet_link('dist/css/skins/skin-blue.min.css') }}
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        {#FIN Archivos Globales#}
        {#Css Particulares#}
        {%  if (assets.collection("headerCss")) %}
            {{  assets.outputCss("headerCss") }}
        {% endif %}
        {#Fin: Css Particulares#}
        {#Js Particulares#}
        {%  if (assets.collection("headerJs")) %}
            {{  assets.outputJs("headerJs") }}
        {% endif %}
        {%  if (assets.collection("headerJsInline")) %}
            {{  assets.outputInlineJs("headerJsInline") }}
        {% endif %}
        {#Fin: Js Particulares#}
    </head>
    <body class="hold-transition skin-blue layout-boxed  ">
        {{ content() }}
        {#Js Globales#}

        {# Bootstrap 3.3.5 #}
        {{ javascript_include('bootstrap/js/bootstrap.min.js') }}
        {# AdminLTE App #}
        {{ javascript_include('dist/js/app.min.js') }}
        {# FastClick     #}
        {{ javascript_include('plugins/fastclick/fastclick.min.js') }}
        {# Calculadora #}
        {{ javascript_include('js/calculadora.js') }}
        {# Slimscroll #}
        {{ javascript_include('plugins/slimScroll/jquery.slimscroll.min.js') }}
        {#Js Particulares#}
        {%  if (assets.collection("footer")) %}
            {{  assets.outputJs("footer") }}
        {% endif %}
        {%  if (assets.collection("footerInline")) %}
            {{  assets.outputInlineJs("footerInline") }}
        {% endif %}
        {#Fin: Js Particulares#}

    </body>

</html>
