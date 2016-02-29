<?php template_set('title', 'Login') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Login</h3>
        </div>
        <div class="panel-body">
          <?php if ( ! empty(error_array())): ?>
            <div class="alert alert-danger" role="alert">
              <?= validation_errors() ?>
            </div>
          <?php endif ?>
          <?= form_open('usuarios/login') ?>
            <div class="form-group">
              <?= form_label('Email:', 'email') ?>
              <?= form_input('email', set_value('email', '', FALSE),
                             'id="email" class="form-control"') ?>
            </div>
            <div class="form-group">
              <?= form_label('Contraseña:', 'password') ?>
              <?= form_password('password', '',
                                'id="password" class="form-control"') ?>
            </div>
            <?= form_submit('login', 'Login', 'class="btn btn-success"') ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
