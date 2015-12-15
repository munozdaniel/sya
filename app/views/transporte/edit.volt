<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Transporte</h3>
</div><!-- /.Titulo -->

<!-- Inicio Formulario -->
{{ form("transporte/save", "method":"post") }}
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("transporte", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <label for="transporte_dominio">Dominio</label>
    <div class="form-group">
        {{ text_field("transporte_dominio", "size" : 30) }}
    </div>
    {#====================================================#}
    <label for="transporte_nroInterno">Número de Interno</label>
    <div class="form-group">
        {{ text_field("transporte_nroInterno", "type" : "numeric") }}
    </div>

</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("transporte_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
