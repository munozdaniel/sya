<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Archivo</h3>
</div><!-- /.Titulo -->
{{ content() }}
{{ form('archivo/create','method':'post','enctype':'multipart/form-data') }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("archivo", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <input type='file' name='files[]' multiple class="btn btn-large btn-primary btn-flat">
</div>
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>

