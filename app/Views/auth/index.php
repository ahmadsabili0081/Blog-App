<?= $this->extend('Templates/template_auth'); ?>

<?= $this->section('contentAuth'); ?>

<div class="login-header box-shadow">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="brand-logo">
      <a href="login.html">
        <img src="/frontend/vendors/images/deskapp-logo.svg" alt="" />
      </a>
    </div>
    <div class="login-menu">
      <ul>
        <li><a href="<?= base_url('admin/register'); ?>">Register</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-lg-7">
        <img src="<?= base_url('frontend/vendors/images/login-page-img.png'); ?>" alt="" />
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary">Login Blog App</h2>
          </div>
          <form action="<?= base_url('admin/submit'); ?>" method="POST">
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
              <input type="text" class="form-control form-control-lg" name="login_value" placeholder="Username or email" value="<?= set_value('login_value'); ?>" />
              <?php if (!empty(session('errors.login_value'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.login_value'); ?></small>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
              <?php if (!empty(session('errors.password'))) :  ?>
                <small class="text-danger ml-1"><?= session('errors.password'); ?></small>
              <?php endif; ?>
            </div>

            <div class="row pb-30">
              <div class="col-6">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1" />
                  <label class="custom-control-label" for="customCheck1">Remember</label>
                </div>
              </div>
              <div class="col-6">
                <div class="forgot-password">
                  <a href="<?= base_url('admin/forgot_password'); ?>">Forgot Password</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="input-group mb-0">
                  <!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                </div>
                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                  OR
                </div>
                <div class="input-group mb-0">
                  <a class="btn btn-outline-primary btn-lg btn-block" href="<?= base_url('admin/register'); ?>">Register To Create Account</a>
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