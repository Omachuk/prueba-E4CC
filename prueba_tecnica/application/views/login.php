<div class="vh-100 d-flex justify-content-center align-items-center">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card bg-white">
          <div class="card-body p-5">
            <form action="<?= base_url();?>index.php/Inicio/login/" class="mb-3 mt-md-4" method="post" accept-charset="utf-8">
              <h2 class="fw-bold mb-2 text-uppercase ">E4CC</h2>
              <p class=" mb-5">Por favor ingrese su correo y contraseña</p>
                <p style="color:red"><?php if(isset($mensaje)) echo $mensaje; ?></p>
                <p><?=validation_errors('<div style="color:red;" class="errors">','</div>');?><!--mostrar los errores de validación-->
                <div class="mb-3">
                  <label for="email" class="form-label ">Correo electronico</label>
                  <input type="email"  class="form-control" id="email" name="email" placeholder="ejemplo@gmail.com">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label ">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="*******">
                </div>
                <div class="d-grid">
                  <button class="btn btn-outline-dark" type="submit">Ingresar</button>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>