<?= $this->extend('Templates/template'); ?>

<?= $this->section('contentPage'); ?>
<div class="page-header">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="title">
        <h4>Profile</h4>
      </div>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.html">Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Profile
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
    <div class="pd-20 card-box height-100-p">
      <div class="profile-photo">
        <a href="javascript:;" onclick="event.preventDefault();document.getElementById('user_profile_file').click();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
        <input type="file" name="user_profile_file" id="user_profile_file" class="d-none" style="
        opacity: 0;">
        <img src="<?= base_url('frontend/images/user/' . get_user_session()['picture']); ?>" alt="" class="avatar-photo ci_avatar_photo" />

      </div>
      <h5 class="text-center h5 mb-0 ci_user_name"><?= get_user_session()['name'];  ?></h5>
      <p class="text-center text-muted font-14">
        <?= get_user_session()['email']; ?>
      </p>
    </div>
  </div>
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
    <div class="card-box height-100-p overflow-hidden">
      <div class="profile-tab height-100-p">
        <div class="tab height-100-p">
          <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#personal_details" role="tab">Detail Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Rubah Password</a>
            </li>
          </ul>
          <div class="tab-content">
            <!-- Timeline Tab start -->
            <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
              <div class="pd-20">
                <form class="personal_details_form" enctype="multipart/form-data" action="<?= base_url('admin/submit_personal_details'); ?>" method="POST">
                  <?= csrf_field(); ?>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= get_user_session()['name']; ?>" placeholder="Name">
                        <small class="text-danger text_error name_error"></small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= get_user_session()['username']; ?>" placeholder="Username">
                        <small class="text-danger text_error username_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" placeholder="Bio..." class="form-control"><?= get_user_session()['bio']; ?></textarea>
                        <small class="text-danger text_error bio_error"></small>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-md btn-primary" type="submit">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Timeline Tab End -->
            <!-- Tasks Tab start -->
            <div class="tab-pane fade" id="change_password" role="tabpanel">
              <div class="pd-20 profile-task-wrap">
                <form id="change_password_form" action="<?= base_url('admin/change_password_submit'); ?>" method="post">
                  <?= csrf_field(); ?>
                  <div class="form-group">
                    <label for="">Password Saat Ini</label>
                    <input type="password" id="password_old" class="form-control" name="password_old" placeholder="Password saat ini">
                    <small class="text-danger text_error password_old_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="">Password Baru</label>
                    <input type="password" id="password_new" class="form-control" name="password_new" placeholder="Password Baru">
                    <small class="text-danger text_error password_new_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="">Konfirmasi Password Baru</label>
                    <input type="password" id="confirm_password_new" class="form-control" name="confirm_password_new" placeholder="Konfirmasi Password Baru">
                    <small class="text-danger text_error confirm_password_new_error"></small>
                  </div>
                  <button class="btn btn-primary" type="submit">Rubah Perubahan</button>
                </form>
              </div>
            </div>
            <!-- Tasks Tab End -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('.personal_details_form').on('submit', function(e) {
      e.preventDefault();

      let form = this;


      // Mengumpulkan nilai input secara manual
      let name = $('#name').val();
      let username = $('#username').val();
      let bio = $('#bio').val();

      // Membuat objek data dengan nilai yang dikumpulkan
      let formData = {
        name: name,
        username: username,
        bio: bio
      };

      // Mengirim data melalui AJAX
      $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formData,
        dataType: 'json',
        beforeSend: function() {
          toastr.remove();
          $(form).find('small.text_error').text('');
        },
        success: function(response) {
          if ($.isEmptyObject(response.error)) {
            if (response.status == 1) {
              $('.ci_user_name').each(function() {
                // response : user info ini ngambil objeck yang telah dibuat json di contoller
                $(this).html(response.user_info.name);
              });
              toastr.success(response.msg);
            } else {
              console.log(response.msg);
              toastr.error(response.msg);
            }
          } else {
            $.each(response.error, function(prefix, val) {
              $(form).find('small.' + prefix + '_error').text(val);
            });
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr);
          console.error(status);
          console.error(error);
          toastr.error('Terjadi kesalahan saat mengirim data.');
        }
      });
    });

    // change password
    $('#change_password_form').on('submit', function(e) {
      e.preventDefault();

      let form = this;

      let password_old = $('#password_old').val();
      let password_new = $('#password_new').val();
      let confirm_password_new = $('#confirm_password_new').val();

      let formdata = {
        password_old: password_old,
        password_new: password_new,
        confirm_password_new: confirm_password_new,
      }

      $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: formdata,
        dataType: 'json',
        beforeSend: function() {
          toastr.remove();
          $(form).find('small.text_error').text('');
        },
        success: function(response) {
          if ($.isEmptyObject(response.error)) {
            if (response.status == 1) {
              $(form)[0].reset();
              toastr.success(response.msg);
            } else {
              toastr.error(response.msg);
            }
          } else {
            $.each(response.error, function(prefix, val) {
              $(form).find('small.' + prefix + '_error').text(val);
            });
          }

        }
      });

    });

  });

  // handle gambar edit
  $('#user_profile_file').ijaboCropTool({
    preview: '.ci_avatar_photo',
    setRatio: 1,
    allowedExtensions: ['jpg', 'jpeg', 'png'],
    processUrl: '<?= base_url('admin/update_profile'); ?>',
    withCSRF: ['<?= csrf_token() ?>', '<?= csrf_hash() ?>'],
    onSuccess: function(message, element, status) {
      if (status == 1) {
        toastr.success(message);
      } else {
        toastr.error(message);
      }
    },
    onError: function(message, element, status) {
      alert(message);
    }
  });
</script>
<?= $this->endSection(); ?>