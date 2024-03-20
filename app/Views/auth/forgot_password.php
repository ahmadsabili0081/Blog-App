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
            <h2 class="text-center text-primary">Lupa Password</h2>
          </div>
          <h6 class="mb-20">
            Masukkan alamat email Anda untuk mengatur ulang kata sandi Anda
          </h6>
          <form action="<?= base_url('admin/send_password'); ?>" method="POST">
            <?= csrf_field(); ?>

            <?php if (!empty(session()->getFlashdata('success'))) :  ?>
              <div class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('fail'))) :  ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('fail'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <input type="text" name="email" class="form-control" placeholder="Email" value="<?= set_value('email'); ?>">
              <?php if (!empty(session('errors.email'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.email'); ?></small>
              <?php endif; ?>
            </div>
            <div class="row align-items-center">
              <div class="col-5">
                <div class="input-group mb-0">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                </div>
              </div>
              <div class="col-2">
                <div class="font-16 weight-600 text-center" data-color="#707373">
                  OR
                </div>
              </div>
              <div class="col-5">
                <div class="input-group mb-0">
                  <a class="btn btn-outline-primary btn-lg btn-block" href="<?= base_url('admin/login'); ?>">Login</a>
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