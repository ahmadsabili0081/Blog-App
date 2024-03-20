<?= $this->extend('Templates/template_auth'); ?>

<?= $this->section('contentAuth'); ?>

<div class="login-header box-shadow">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="brand-logo">
      <a href="login.html">
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
<div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-lg-7">
        <img src="<?= base_url('frontend/vendors/images/register-page-img.png'); ?>" alt="" />
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary">Registrasi Blog App</h2>
          </div>
          <form action="<?= base_url('admin/submit'); ?>" method="POST">
            <?= csrf_field(); ?>
            <input type="hidden" name="registrasi" value="true">
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
              <label for="">Nama</label>
              <input type="text" class="form-control form-control-lg" name="name" placeholder="Nama" value="<?= set_value('name'); ?>" />
              <?php if (!empty(session('errors.name'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.name'); ?></small>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="">Username</label>
              <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" />
              <?php if (!empty(session('errors.username'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.username'); ?></small>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="">Email</label>
              <input type="text" name="email" class="form-control form-control-lg" placeholder="Email" />
              <?php if (!empty(session('errors.email'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.email'); ?></small>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
              <?php if (!empty(session('errors.password'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.password'); ?></small>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="">Konfirmasi Password</label>
              <input type="password" name="password2" class="form-control form-control-lg" placeholder="Konfirmasi Password" />
              <?php if (!empty(session('errors.password2'))) :  ?>
                <small class=" text-danger ml-1"><?= session('errors.password2'); ?></small>
              <?php endif; ?>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="input-group mb-0">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Registrasi</button>
                </div>
                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                  OR
                </div>
                <div class="input-group mb-0">
                  <a class="btn btn-outline-primary btn-lg btn-block" href="<?= base_url('admin/login'); ?>">Sign In</a>
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