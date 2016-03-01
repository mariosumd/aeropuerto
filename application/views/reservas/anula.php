<?php template_set('title', 'Anula reserva') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Confirma anulación</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <?= form_open('reservas/anula') ?>
                    <?= form_hidden('id_reserva', $vuelo['id_reserva']) ?>
                    <h3>¿Está seguro de anular el siguiente vuelo?</h3>
                    <?= form_label($vuelo['compania']." ".$vuelo['vuelo'].": ".$vuelo['origen'].
                                    "-".$vuelo['destino'].". Salida -> ".$vuelo['salida'].
                                    ". Llegada -> ".$vuelo['llegada'].
                                    " [Asiento: ".$vuelo['asiento']."]".
                                    " Comprada: ".$vuelo['comprada']) ?>
                    <br />
                    <?= form_submit('confirmar', 'Confirmar', 'class="btn btn-success"') ?>
                <?= form_close() ?>
                </div>
        </div>
      </div>
    </div>
  </div>
</div>
