<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">{{ content() }}</h3>
        <p>Que desea hacer?</p>
        <p>{{ link_to('remito/agregar/'~planilla_id,'Continuar agregando remitos','class':'btn btn-flat bg-light-blue-gradient') }}</p>
        <p>{{ link_to('planilla/view/'~planilla_id,'Ver datos de la planilla','class':'btn btn-flat bg-light-blue-gradient') }}</p>
        <p>{{ link_to('remito/buscarRemitos/'~planilla_id,'Ver todos los remitos','class':'btn btn-flat bg-light-blue-gradient') }}</p>
    </div>
</div>
<!-- Formulario -->
