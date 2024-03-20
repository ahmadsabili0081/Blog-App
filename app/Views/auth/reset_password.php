<?= $this->extend('Templates/template_auth'); ?>

<?= $this->section('contentAuth'); ?>

<div class="login-header box-shadow">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="brand-logo">
      <a href="<?= base_url(''); ?>">
        <img src="<?= base_url('frontend/vendors/images/deskapp-logo.svg'); ?>" alt="" />
      </a>
    </div>
    <div class="login-menu">
      <ul>
        <li><a href="<?= base_url('admin/login'); ?>">Login</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <img src="<?= base_url('frontend/vendors/images/forgot-password.png'); ?>" alt="" />
      </div>
      <div class="col-md-6">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary">Reset Password</h2>
          </div>

          <h6 class="mb-20">Masukkan kata sandi baru Anda, konfirmasi dan Submit</h6>
          <form action="<?= base_url('admin/reset_password_submit/' . $token);  ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
              <label for="">Password</label>
              <input type="password" class="form-control" name="password" value="<?= old('password'); ?>" placeholder="Password">
              <?php if (!empty(session('errors.password'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.password'); ?></small>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="">Konfirmasi Password</label>
              <input type="password" class="form-control" value="<?= old('password2'); ?>" name="password2" placeholder="Konfirmasi Password">
              <?php if (!empty(session('errors.password2'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.password2'); ?></small>
              <?php endif; ?>
            </div>
            <div class="row align-items-center">
              <div class="col-5">
                <div class="input-group mb-0">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>