
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("remito/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("remito/new", "Create ") }}
        </td>
    </tr>
</table>
<div class="box-body">
    <div id="toolbar">
        <label>
            <select class="form-control">
                <option value="">Exportar Pagina</option>
                <option value="all">Exportar Todo</option>
                <option value="selected">Exportar Seleccionados</option>
            </select>
        </label>
    </div>
    <table data-toggle="table"
           data-url="data"
           data-query-params="queryParams"
           data-pagination="true"
           data-search="true"
           data-height="300"
           {#Fin: Basico #}
           data-show-pagination-switch="true"
           data-page-list="[3, 25, 50, 100, ALL]"
           data-escape="false"{# Para usar html en las celdas#}
           data-toolbar="#toolbar"
           data-reorderable-columns="true"
           data-show-export="true"
           data-click-to-select="true"
           data-row-style="rowStyle"
           class="">
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            {% for col in columnas %}
                <th data-sortable="true">{{ col.columna_nombre }}</th>
            {% endfor %}
        </tr>
        </thead>
    </table>
</div>
<script>
    function queryParams() {
        return {
            type: 'owner',
            sort: 'updated',
            direction: 'desc',
            per_page: 100,
            page: 1
        };
    }
</script>

<script>
    //evitamos el comportamiento por defecto de los links
    $(document).on("click", "a", function(e){
        e.preventDefault();
    });

    function paginate(offset, limit)
    {
        //obtenemos los posts via get con jQuery
        $.get("data/?offset=" + offset + "&limit=" + limit, function(data){
            if(data)
            {
                console.log(data);
                $html = "";
                //parseamos el json
                json = JSON.parse(data);
                //lo recorremos e insertamos en la variable $html
                for(datos in json.posts)
                {
                    $html += "<div class='panel'>";
                    $html += "<p>Id: " + json.posts[datos].remito_id + "</p>";
                    $html += "<p>Título: " + json.posts[datos].remito_nro + "</p>";
                    $html += "<p>Autor: " + json.posts[datos].remito_transporteId + "</p>";
                    $html += "<p>Contenido: " + json.posts[datos].remito_fecha + "</p>";
                    $html += "</div>";
                }

                //cargamos los posts en el div paginacion
                $(".paginacion").html("");
                $(".paginacion").html($html);
                //cargamos los links en el div links
                $(".links").html("");
                $(".links").html(json.links);

                //hacemos una sencilla animacion
                $(document.body).animate({opacity: 0.3}, 400);
                $("html, body").animate({ scrollTop: 0 }, 400);
                $(document.body).animate({opacity: 1}, 400);
            }
        })
    }

    //al cargar la página llamamos a la función paginate
    $(window).bind("load", function(){
     //   paginate();
    })
</script>