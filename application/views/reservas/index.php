<?php template_set('title', 'Reserva') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Reserva</h3>
        </div>
        <div class="panel-body">
            <?php if($vuelos !== FALSE): ?>
                <div class="form-group">
                    <?= form_open('reservas/reserva') ?>
                        <?php foreach($vuelos as $vuelo): ?>
                            <?= form_label($vuelo['compania']." ".$vuelo['vuelo'].": ".$vuelo['origen'].
                                            "-".$vuelo['destino'].". Salida -> ".$vuelo['salida'].
                                            ". Llegada ->".$vuelo['llegada'].
                                            " [Plazas disponibles:".$vuelo['plazas']."]") ?>
                            <?= form_radio('vuelo', $vuelo['vuelo'], TRUE) ?>
                            <br />
                        <?php endforeach; ?>
                        <?= form_submit('reservar', 'Reservar', 'class="btn btn-success"') ?>
                    <?= form_close() ?>
                </div>
            <?php else: ?>
                <h3>No se han encontrado vuelos</h3>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if ($reservas !== FALSE): ?>
    <div class="container-fluid" style="padding-top:20px">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Tus reservas</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                        <?php foreach($reservas as $reserva): ?>
                            <?= form_open('reservas/anula') ?>
                                <?= form_hidden('id_reserva', $reserva['id_reserva']) ?>
                                <?= form_label($reserva['compania']." ".$reserva['vuelo'].": ".$reserva['origen'].
                                                "-".$reserva['destino'].". Salida -> ".$reserva['salida'].
                                                ". Llegada -> ".$reserva['llegada'].
                                                " [Asiento: ".$reserva['asiento']."]".
                                                " Comprada: " . $reserva['comprada']) ?>
                                <?= form_submit('anular', 'Anular', 'class="btn btn-danger btn-sm"') ?>
                            <?= form_close() ?>
                            <br />
                        <?php endforeach; ?>

                </div>
              </div>
            </div>
         </div>
       </div>
     </div>
<?php endif; ?>
