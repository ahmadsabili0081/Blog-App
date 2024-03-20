<?= $this->extend('Templates/template'); ?>

<?= $this->section('contentPage'); ?>
<div class="page-header">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="title">
        <h4>Settings</h4>
      </div>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/settings'); ?>">Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Settings
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 mb-30">
    <div class="pd-20 card-box">
      <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#general_settings" role="tab" aria-selected="true">Pengaturan Umum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo & Favicon</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#social_media" role="tab" aria-selected="false">Media sosial</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active show" id="general_settings" role="tabpanel">
            <div class="pd-20">
              <form class="update_general_settings" action="<?= base_url('admin/update_general_settings'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Judul Blog</label>
                      <input type="text" name="blog_title" id="blog_title_value" class="form-control" value="<?= $get_data['blog_title']; ?>" placeholder="Blog Title..">
                      <small class="text-danger text_error blog_title_error"></small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Email Blog</label>
                      <input type="text" name="blog_email" id="blog_email_value" value="<?= $get_data['blog_email']; ?>" class="form-control" placeholder="Blog Email..">
                      <small class="text-danger text_error blog_email_error"></small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">No Telepon Blog</label>
                      <input type="text" name="blog_no_telp" id="blog_no_telp_value" class="form-control" value="<?= $get_data['blog_no_telp']; ?>" placeholder="Blog No Telepon..">
                      <small class="text-danger text_error blog_no_telp_error"></small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Kata Kunci Meta Blog</label>
                      <input type="text" name="blog_meta_keywords" id="blog_meta_keywords_value" value="<?= $get_data['blog_meta_keywords']; ?>" class="form-control" placeholder="Blog Meta Keywords..">
                      <small class="text-danger text_error blog_meta_keywords_error"></small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md">
                    <div class="form-group">
                      <label for="">Deskripsi Blog</label>
                      <textarea name="description_blog" id="description_blog_value" placeholder="Deskripsi Blog..." class="form-control"><?= $get_data['description_blog']; ?></textarea>
                      <small class="text-danger text_error description_blog_error "></small>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
          <div class="tab-pane fade" id="logo_favicon" role="tabpanel">
            <div class="pd-20">
              <div class="row">
                <div class="col-md-6">
                  <h5>Set Blog Logo</h5>
                  <div class="mb-2 mt-1" style="max-width: 200px;">
                    <img src="<?= base_url('frontend/images/blog/' . $get_data['blog_logo']); ?>" class="img-thumbnail" id="logo_image_preview">
                  </div>
                  <form id="update_logo" action="<?= base_url('admin/update_logo'); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-2">
                      <input type="file" class="form-control" id="change_logo_form" name="blog_logo">
                      <small class="text-danger text_error"></small>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan Gambar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="social_media" role="tabpanel">
            <div class="pd-20">
              <form class="social_media_submit" action="<?= base_url('admin/social_media_submit'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Youtube URL</label>
                      <input type="text" class="form-control" value="<?= get_social_media()['youtube_url']; ?>" id="youtube_url_value" name="youtube_url" placeholder="Youtube Url..">
                      <small class="text-danger text_error youtube_url_error"></small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Facebook URL</label>
                      <input type="text" class="form-control" value="<?= get_social_media()['facebook_url']; ?>" id="facebook_url_value" name="facebook_url" placeholder="Facebook Url..">
                      <small class="text-danger text_error facebook_url_error"></small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Github URL</label>
                      <input type="text" class="form-control" id="github_url_value" value="<?= get_social_media()['github_url'] ?>" name="github_url" placeholder="Github Url...">
                      <small class="text-danger text_error github_url_error"></small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Twitter URL</label>
                      <input type="text" class="form-control" id="twitter_url_value" value="<?= get_social_media()['twitter_url']; ?>" name="twitter_url" placeholder="Twitter Url..">
                      <small class="text-danger text_error twitter_url_error"></small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Linkedin URL</label>
                      <input type="text" class="form-control" id="linkedin_url_value" value="<?= get_social_media()['linkedin_url'] ?>" name="linkedin_url" placeholder="Linkedin Url..">
                      <small class="text-danger text_error linkedin_url_error"></small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Instagram URL</label>
                      <input type="text" class="form-control" id="instagram_url_value" value="<?= get_social_media()['instagram_url'] ?>" name="instagram_url" placeholder="Instagram Url..">
                      <small class="text-danger text_error instagram_url_error"></small>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
              </form>
            </div>
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
    $('.update_general_settings').on('submit', function(e) {
      e.preventDefault();

      let form = this;

      let blog_title_value = $('#blog_title_value').val();
      let blog_email_value = $('#blog_email_value').val();
      let blog_no_telp = $('#blog_no_telp_value').val();
      let blog_meta_keywords = $('#blog_meta_keywords_value').val();
      let description_blog = $('#description_blog_value').val();

      let formData = {
        blog_title: blog_title_value,
        blog_email: blog_email_value,
        blog_no_telp: blog_no_telp,
        blog_meta_keywords: blog_meta_keywords,
        description_blog: description_blog
      }

      $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: formData,
        dataType: 'json',
        beforeSend: function() {
          toastr.remove();
          $(form).find('small.text_error').text('');
        },
        success: function(response) {
          if ($.isEmptyObject(response.error)) {
            if (response.status == 1) {
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


    $('.social_media_submit').on('submit', function(e) {
      e.preventDefault();

      let form = this;

      let youtube_url_value = $('#youtube_url_value').val();
      let facebook_url_value = $('#facebook_url_value').val();
      let github_url_value = $('#github_url_value').val();
      let twitter_url_value = $('#twitter_url_value').val();
      let linkedin_url_value = $('#linkedin_url_value').val();
      let instagram_url_value = $('#instagram_url_value').val();

      let formData = {
        youtube_url: youtube_url_value,
        facebook_url: facebook_url_value,
        github_url: github_url_value,
        twitter_url: twitter_url_value,
        linkedin_url: linkedin_url_value,
        instagram_url: instagram_url_value
      }

      $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: formData,
        dataType: 'json',
        beforeSend: function() {
          toastr.remove();
          $(form).find('small.text_error').text('');
        },
        success: function(response) {
          if ($.isEmptyObject(response.error)) {
            if (response.status == 1) {
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

  $('#change_logo_form').on('change', function(e) {
    e.preventDefault();
    let file = this.files[0];
    if (file && file.type === "image/png") {
      let reader = new FileReader();
      reader.onload = function(e) {
        $('#logo_image_preview').attr('src', e.target.result);
      }
      reader.readAsDataURL(file);
    } else {
      toastr.error('Gambar bukan bertipe PNG!');
      $(this).val('');
      $('#logo_image_preview').attr('src', '<?= base_url('frontend/images/blog/default.png'); ?>');
    }
  });

  $('#update_logo').on('submit', function(e) {
    e.preventDefault();
    let file_input = $('input[type="file"][name="blog_logo"]');

    // Pastikan elemen input file ditemukan
    if (file_input.length > 0) {
      let file = file_input[0].files[0];

      // Pastikan file ada sebelum melanjutkan
      if (file) {
        let formData = new FormData();
        formData.append('blog_logo', file);

        $.ajax({
          url: $(this).attr('action'),
          method: $(this).attr('method'),
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend: function(xhr) {
            toastr.remove();
            $(this).find('small.text_error').text(''); // Menetapkan teks kosong ke elemen dengan class text_error
          },
          success: function(response) {
            if (response.status == 1) {
              toastr.success(response.msg);
            } else {
              toastr.error(response.msg);
            }
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseJSON);
          }
        });
      } else {
        toastr.error('Mohon pilih file Logo!');
      }
    } else {
      toastr.error('Elemen input file tidak ditemukan!');
    }
  });
</script>
<?= $this->endSection(); ?>