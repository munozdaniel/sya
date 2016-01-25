<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado de Lineas</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("orden/index", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("orden/new", "CREAR ",'class':'btn btn-flat btn-large btn-danger') }}
            </td>
        </tr>
    </table>
</div>
{{ content() }}
<script>
    $(document).ready(function () {
            $('#tabla_id').DataTable( {
                "scrollX": true
            } );
    });
</script>