<div class="box-header with-border">
    <h3 class="box-title">Editar planilla</h3>
</div><!-- /.box-header -->
<!-- form start -->

{{ content() }}
                {{ form("planilla/save", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("planilla", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<div class="box-body">
    <label for="planilla_nombreCliente">Nombre de la Planilla</label>

    <div class="form-group">
        {{ text_field("planilla_nombreCliente", "size" : 30) }}
    </div>
</div><!-- /.box-body -->

<div class="box-footer">
    {{ hidden_field("planilla_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>


