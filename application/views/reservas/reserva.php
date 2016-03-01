<?php template_set('title', 'Confirma reserva') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Confirma reserva</h3>
        </div>
        <div class="panel-body">

                <?= form_open('reservas/reserva') ?>
                    <?= form_hidden('id_vuelo', $vuelo['vuelo']) ?>
                    <h3>Elija asiento y confirme la reserva</h3>
                    <div class="form-group">
                    <?= form_label($vuelo['compania']." ".$vuelo['vuelo'].": ".$vuelo['origen'].
                                    "-".$vuelo['destino']." -> ".$vuelo['salida'].
                                    " [Plazas disponibles:".$vuelo['plazas']."]") ?>
                    </div>
                    <div class="form-group">
                        <?= form_label('Asiento') ?>
                        <?= form_dropdown('asiento', $asientos) ?>
                    </div>
                    <?= form_submit('confirmar', 'Confirmar', 'class="btn btn-success"') ?>
                <?= form_close() ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
