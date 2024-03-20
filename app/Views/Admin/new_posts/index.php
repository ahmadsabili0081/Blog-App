<?= $this->extend('Templates/template'); ?>

<?= $this->section('contentPage'); ?>
<div class="page-header">
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="title">
        <h4>Tambah Postingan</h4>
      </div>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin'); ?>">Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Tambah Postingan
          </li>
        </ol>
      </nav>
    </div>
    <div class="col-md-6 col-sm-12 text-right">
      <div class="dropdown">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Lihat Semua Postingan
        </a>
      </div>
    </div>
  </div>
</div>
<form action="<?= base_url('admin/posts/submit_posts'); ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="add_post_form">
  <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
  <div class="form-group">
    <div class="row">
      <div class="col-md-9">
        <div class="card card-box mb-2">
          <div class="card-body">
            <div class="form-group">
              <label for="">Judul Postingan</label>
              <input type="text" name="post_title" placeholder="Judul Postingan" class="form-control">
              <small class="text-danger text_error post_title_error"></small>
            </div>
            <div class="form-group">
              <label for="">Konten</label>
              <textarea name="content" id="content" class="form-control" placeholder="Konten Postingan"></textarea>
              <small class="text-danger text_error content_error"></small>
            </div>
          </div>
        </div>
        <div class="card-box mb-2">
          <div class="card-header weight-500">SEO</div>
          <div class="card-body">
            <div class="form-group">
              <label for=""><b>posting kata kunci meta</b> <small>(dipisahkan dengan koma)</small></label>
              <input type="text" class="form-control" name="meta_keywords" placeholder="Postingan Kata Kunci Meta">
              <small class="text-danger text_error meta_keywords_error"></small>
            </div>
            <div class="form-group">
              <label for="">posting deskripsi meta</label>
              <textarea name="meta_description" class="form-control" placeholder="Ketik deskripsi meta"></textarea>
              <small class="text-danger text_error meta_description_error"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-box mb2">
          <div class="card-body">
            <div class="form-group">
              <label for="">Kategori Postingan</label>
              <select class="custom-select2 form-control" name="id_kategori" style="width: 100%; height: 38px">
                <option value="">--Pilih Kategori--</option>
                <?php foreach ($categories as $category) :  ?>
                  <option value="<?= $category['id_kategori']; ?>"><?= $category['kategori']; ?></option>
                <?php endforeach; ?>
              </select>
              <small class="text-danger text_error id_kategori_error"></small>
            </div>
            <div class="form-group">
              <label for="">Memposting gambar unggulan</label>
              <input type="file" name="featured_image" class="form-control-file form-control" height="auto">
              <small class="text-danger text_error featured_image_error"></small>
            </div>
            <div class="d-block mb-3" style="max-width: 250px;">
              <img class="img-thumbnail" id="image-preview" src="<?= base_url('frontend/images/blog/default.png'); ?>" data-ijabo-default-img="">
            </div>
            <div class="form-group">
              <label for="">Tags</label>
              <input type="text" class="form-control" id="tags" placeholder="Tags" data-role="tagsinput" name="tags">
              <small class="text-danger text_error tags_error"></small>
            </div>
            <div class="form-group">
              <label for=""><b>Visibilitas</b></label>
              <div class="custom-control custom-radio mb-5">
                <input type="radio" id="customRadio1" name="visibility" value="1" class="custom-control-input" checked>
                <label class="custom-control-label" for="customRadio1">Public</label>
              </div>
              <div class="custom-control custom-radio mb-5">
                <input type="radio" id="customRadio2" value="0" name="visibility" class="custom-control-input">
                <label class="custom-control-label" for="customRadio2">Private</label>
              </div>
              <small class="text-danger text_error visibility_error"></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mb-3">
    <button class="btn btn-md btn-primary" type="submit">Buat Postingan</button>
  </div>
</form>
<?= $this->endSection(); ?>

<?= $this->section('stylesheets'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('frontend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>">
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?= base_url('frontend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>"></script>
<script src="<?= base_url('frontend/ckeditor/ckeditor.js'); ?>"></script>
<script>
  // handle gambar edit
  $('input[type="file"][name="featured_image"]').on('change', function(e) {
    e.preventDefault();
    let file = this.files[0];
    if (file && (file.type === "image/png" || file.type === "image/jpeg" || file.type === "image/jpg")) {
      let reader = new FileReader();
      reader.onload = function(e) {
        $('#image-preview').attr('src', e.target.result);
      }
      reader.readAsDataURL(file);
    } else {
      toastr.error('Gambar bukan bertipe PNG!');
      $(this).val('');
      $('#image-preview').attr('src', '<?= base_url('frontend/images/blog/default.png'); ?>');
    }
  });


  $('#add_post_form').on('submit', function(e) {
    e.preventDefault();
    let form = this;
    let csrfName = $('.ci_csrf_data').attr('name');
    let csrfHash = $('.ci_csrf_data').val();
    let content = CKEDITOR.instances.content.getData();
    let formData = new FormData(form);
    formData.append(csrfName, csrfHash);
    formData.append('content', content);

    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      dataType: 'json',
      beforeSend: function(response) {
        toastr.remove();
        $(form).find('small.text_error').html('');
      },
      success: function(response) {
        $('.ci_csrf_data').val(response.token);
        if ($.isEmptyObject(response.error)) {
          if (response.status == 1) {
            $(form)[0].reset();
            CKEDITOR.instances.content.setData('');
            $('img#image-preview').attr('src', '<?= base_url('frontend/images/blog/default.png'); ?>');
            toastr.success(response.msg);
          } else {
            toastr.error(response.msg);
          }
        } else {
          $.each(response.error, function(prefix, val) {
            console.log(val);
            $(form).find('small.' + prefix + '_error').text(val);
          });
        }
      },

      error: function(xhr) {
        console.log(xhr);
      }
    });
  });

  // tambakan insctance agar bisa mendapat kan value content
  $(document).ready(function(e) {
    let elFinderPath = "/frontend/elFinder/elfinder.src.php?integration=ckeditor&uid=<?= get_user_session()['id_user']; ?>";
    // setelah menambahkan dibawah ini
    // tahap kedua kita menambahkan file elfinder.scr.php nya
    // tahap ke tiga kita menambahkan script di connector.minimal.php elfinder
    CKEDITOR.replace('content', {
      filebrowserBrowseUrl: elFinderPath,
      filebrowserImageBrowserUrl: elFinderPath + '&type=image',
      removeDialogTabs: 'link:upload;image:upload'
    });
  });
</script>
<?= $this->endSection(); ?>