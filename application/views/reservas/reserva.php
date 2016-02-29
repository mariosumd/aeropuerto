<?php template_set('title', 'Confirma reserva') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Confirma reserva</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <?= form_open('reservas/reserva') ?>
                    <?= form_hidden('id_vuelo', $vuelo['id']) ?>
                    <h3>¿Está seguro de reservar el siguiente vuelo?</h3>
                    <?= form_label($vuelo['companyia']." ".$vuelo['vuelo'].": ".$vuelo['origen'].
                                    "-".$vuelo['destino']." -> ".$vuelo['salida'].
                                    " [Plazas disponibles:".$vuelo['plazas']."]") ?>
                    <br />
                    <?= form_submit('confirmar', 'Confirmar', 'class="btn btn-success"') ?>
                <?= form_close() ?>
                </div>
        </div>
      </div>
    </div>
  </div>
</div>
