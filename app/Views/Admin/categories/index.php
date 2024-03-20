<?= $this->extend('Templates/template'); ?>

<?= $this->section('contentPage'); ?>
<div class="page-header">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="title">
        <h4>Kategori</h4>
      </div>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/settings'); ?>">Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Kategori
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 mb-4">
    <div class="card card-box">
      <div class="card-header">
        <div class="clearfix">
          <div class="pull-left">
            Kategori
          </div>
          <div class="pull-right">
            <a href="" class="btn btn-default btn-sm p-0" role="button" id="add_category_button">
              <i class="fa fa-plus-circle"></i> Tambah Kategori
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-borderless table-hover table-striped" id="categories-table">
          <thead>
            <tr>
              <th scope="col" class="text-center">No</th>
              <th scope="col" class="text-center">Nama Kategori</th>
              <th scope="col" class="text-center">Sub Kategori</th>
              <th scope="col" class="text-center">Action</th>
              <th scope="col" class="text-center">Ordering</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-12 mb-4">
    <div class="card card-box">
      <div class="card-header">
        <div class="clearfix">
          <div class="pull-left">
            Sub Kategori
          </div>
          <div class="pull-right">
            <a href="" class="btn btn-default btn-sm p-0" role="button" id="add_sub_category_button">
              <i class="fa fa-plus-circle"></i> Tambah Sub Kategori
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-borderless table-hover table-striped" id="sub_category_table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Sub Kategori</th>
              <th scope="col">Kategori</th>
              <th scope="col">Posts</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->include('modals/categories_modal'); ?>
<?= $this->include('modals/edit_categories_modal'); ?>
<?= $this->include('modals/sub_categories'); ?>
<?= $this->include('modals/edit_sub_categori'); ?>

<?= $this->endSection(); ?>
<?= $this->section('stylesheets'); ?>
<link rel="stylesheet" href="<?= base_url('frontend/src/plugins/datatables/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/src/plugins/datatables/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/package/dist/sweetalert2.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/jquery-ui-1.13.2/jquery-ui.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/jquery-ui-1.13.2/jquery-ui.structure.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/jquery-ui-1.13.2/jquery-ui.theme.min.css'); ?>">
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?= base_url('frontend/src/plugins/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('frontend/src/plugins/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('frontend/src/plugins/datatables/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('frontend/package/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= base_url('frontend/jquery-ui-1.13.2/jquery-ui.min.js'); ?>"></script>
<script>
  $(document).on('click', '#add_category_button', function(e) {
    e.preventDefault();

    let modal = $('body').find('#categori_modal');
    let modalTitle = 'Tambah Kategori';
    let modalBtnText = "Tambah";

    modal.find('.modal-title').html(modalTitle);
    modal.find('.modal-footer > button.action').html(modalBtnText);
    modal.modal('show');

    $('#kategori_submit').on('submit', function(e) {
      e.preventDefault();
      let form = this;
      let csrfName = $('.ci_csrf_data').attr('name');
      let csrfHash = $('.ci_csrf_data').val();

      let modal = $('body').find('div#categori_modal');
      let formData = new FormData(form);
      formData.append(csrfName, csrfHash);

      $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        cache: false,
        beforeSend: function(response) {
          toastr.remove();
          $(form).find('small.text_error').text('');
        },
        success: function(response) {
          $('.ci_csrf_data').val(response.token);
          if ($.isEmptyObject(response.error)) {
            if (response.status == 1) {
              $(form)[0].reset();
              modal.modal('hide');
              toastr.success(response.msg);
              categories_datatables.ajax.reload(null, false); //update datables
              subCategoryTable.ajax.reload(null, false);
            } else {
              toastr.error(response.msg);
            }
          } else {
            $.each(response.error, function(prefix, val) {
              $(form).find('small.' + prefix + '_error').text(val);
            });
          }
        },
      });
    });
  });
  // langkah awal 
  // tambahkan datables js dan css nya
  let categories_datatables = $('#categories-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= base_url('admin/get_categories'); ?>",
    dom: "Brtip",
    info: true,
    fnCreatedRow: function(row, data, index) {
      $('td', row).eq(0).html(index + 1);
      $('td', row).parent().attr('data-index', data[0]).attr('data-ordering', data[4]);
    },
    columDefs: [{
        ordertable: false,
        targets: [0, 1, 2, 3]
      },
      {
        visible: false,
        targets: 4
      }
    ],
    order: [
      ['4', 'asc']
    ]
  });

  $(document).on('click', '.editCategoryBtn', function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    let url = "<?= base_url('admin/get_categories_update'); ?>";
    $.get(url, {
      id_kategori: id
    }, function(response) {
      let modalTitle = "Edit Kategori";
      let modalBtnText = "Simpan Perubahan";
      let modal = $('body').find('div.editCategory');
      modal.find('form').find('input[type="hidden"][name="id_kategori"]').val(id);
      modal.find('.modal-title').html(modalTitle);
      modal.find('.modal-footer > button.action').html(modalBtnText);
      modal.find('input[type="text"]').val(response.data[0].kategori);
      modal.find('small.text_error').html('');
      modal.modal('show');
    }, 'json');
  });

  $('#update_categories').on('submit', function(e) {
    e.preventDefault();
    let form = this;
    let csrfName = $('.ci_csrf_data').attr('name');
    let csrfHash = $('.ci_csrf_data').val();
    let modal = $('body').find('div.editCategory');

    let formData = new FormData(form);
    formData.append(csrfName, csrfHash);

    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      cache: false,
      beforeSend: function(response) {
        toastr.remove();
        $(form).find('small.text_error').text('');
      },
      success: function(response) {
        $('.ci_csrf_data').val(response.token);
        if ($.isEmptyObject(response.error)) {
          if (response.status == 1) {
            $(form)[0].reset();
            modal.modal('hide');
            toastr.success(response.msg);
            categories_datatables.ajax.reload(null, false); //update datables
            subCategoryTable.ajax.reload(null, false);
          } else {
            toastr.error(response.msg);
          }
        } else {
          $.each(response.error, function(prefix, val) {
            $(form).find('small.' + prefix + '_error').text(val);
          });
        }
      },
      error: function(xhr) {
        console.log(xhr);
      }
    });
  });

  $(document).on('click', '.deleteCategoriBtn', function(e) {
    e.preventDefault();
    let id_kategori = $(this).data('id');
    let url = "<?= base_url('admin/delete_category'); ?>";

    Swal.fire({
      title: "Apakah anda yakin?",
      text: "Ingin Menghapus kategori!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.get(url, {
          id_kategori: id_kategori
        }, function(response) {
          console.log(response);
          if (response.status == 1) {
            categories_datatables.ajax.reload(null, false);
            subCategoryTable.ajax.reload(null, false);
            toastr.success(response.msg);
          } else {
            toastr.error(response.msg);
          }
        }, 'json');
      }
    });
  });

  //Langkah ketiga 
  $('#categories-table').find('tbody').sortable({
    update: function(event, ui) {
      $(this).children().each(function(index) {
        if ($(this).attr('data-ordering') != (index + 1)) {
          $(this).attr('data-ordering', (index + 1)).addClass('update');
        }
      });
      let positions = [];

      $('.update').each(function() {
        positions.push([$(this).attr('data-index'), $(this).attr('data-ordering')]);
        $(this).removeClass('update');
      });
      let url = "<?= base_url('admin/reorder_categories'); ?>";
      $.get(url, {
        positions: positions
      }, function(response) {
        if (response.status == 1) {
          categories_datatables.ajax.reload(null, false);
          toastr.success(response.msg);
        }
      }, 'json');
    }
  });

  $('#add_sub_category_button').on('click', function(e) {
    e.preventDefault();
    let modalTitle = "Tambah Sub Kategori";
    let modalBtnText = "Simpan";
    let modal = $('body').find('div#sub_categori_modal');
    let selectModal = modal.find('select[name="id_kategori"]');
    let url = "<?= base_url('admin/get_parent_category'); ?>";
    $.getJSON(url, {
      id_kategori: null
    }, function(response) {
      selectModal.find('option').remove();
      selectModal.html(response.data);
    });
    modal.find('.modal-title').html(modalTitle);
    modal.find('.modal-footer > button.action').html(modalBtnText);
    modal.find('input[type="text"]').val('');
    modal.find('textarea').html('');
    modal.find('small.text_error').html('');
    modal.modal('show');
  });

  // sub kategori
  $(document).on('submit', '#sub_kategori', function(e) {
    e.preventDefault();
    let form = this;
    let csrfName = $('.ci_csrf_data').attr('name');
    let csrfHash = $('.ci_csrf_data').val();
    let modal = $('body').find('div#sub_categori_modal');
    let formData = new FormData(form);
    formData.append(csrfName, csrfHash);

    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      cache: false,
      beforeSend: function(response) {
        toastr.remove();
        $(form).find('small.text_error').text('');
      },
      success: function(response) {
        $('.ci_csrf_data').val(response.token);
        if ($.isEmptyObject(response.error)) {
          if (response.status == 1) {
            $(form)[0].reset();
            modal.modal('hide');
            toastr.success(response.msg);
            categories_datatables.ajax.reload(null, false); //update datables
            subCategoryTable.ajax.reload(null, false);
          } else {
            toastr.error(response.msg);
          }
        } else {
          $.each(response.error, function(prefix, val) {
            $(form).find('small.' + prefix + '_error').text(val);
          });
        }
      },
      error: function(xhr) {
        console.log(xhr);
      }
    });

  });

  // table sub categories
  let subCategoryTable = $('#sub_category_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= base_url('admin/get_sub_category'); ?>",
    dom: "Brtip",
    info: true,
    fnCreatedRow: function(row, data, index) {
      $('td', row).eq(0).html(index + 1);
      $('td', row).parent().attr('data-index', data[0]).attr('data-ordering', data[5]);
    },
    columnDefs: [{
      ordertable: false,
      targets: [0, 1, 2, 3, 4],
    }, {
      visible: false,
      targets: 5
    }],
    order: [
      [5, 'asc']
    ]
  });

  $(document).on('click', '.editSubCategoryBtn', function(e) {
    e.preventDefault();
    let form = this;
    let idSub = $(form).data('id');
    let get_sub_category_url = "<?= base_url('admin/getSubCategory'); ?>";
    let get_parent_category = "<?= base_url('admin/get_parent_category'); ?>";
    let modalTitle = "Edit Sub Kategori";
    let modalBtnText = "Simpan Perubahan";
    let modal = $('body').find('div#edit_sub_categori_modal');
    modal.find('.modal-title').html(modalTitle);
    modal.find('.modal-footer > button.action').html(modalBtnText);
    modal.find('small.text_error').html('');
    let selectCategory = modal.find('select[name="id_kategori"]');
    $.getJSON(get_sub_category_url, {
      id_sub: idSub
    }, function(response) {
      modal.find('form').find('input[type="hidden"][name="id_sub"]').val(idSub);
      modal.find('input[type="text"][name="sub_kategori"]').val(response.data.sub_kategori);
      modal.find('textarea[name="description"]').val(response.data.description);
      $.getJSON(get_parent_category, {
        id_kategori: response.data.id_kategori
      }, function(response) {
        console.log(response.data);
        selectCategory.find('option').remove();
        selectCategory.html(response.data);
      });
      modal.modal('show');
    });
  });

  $('#edit_sub_kategori').on('submit', function(e) {
    e.preventDefault();

    let form = this;
    let csrfName = $('.ci_csrf_data').attr('name');
    let csrfHash = $('.ci_csrf_data').val();

    let modal = $('body').find('div#edit_sub_categori_modal');
    let formData = new FormData(form);
    formData.append(csrfName, csrfHash);

    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: formData,
      contentType: false,
      processData: false,
      cache: true,
      dataType: 'json',
      beforeSend: function(response) {
        toastr.remove();
        $(form).find('small.text_error').text('');
      },
      success: function(response) {
        $('.ci_csrf_data').val(response.token);
        if ($.isEmptyObject(response.error)) {
          if (response.status == 1) {
            $(form)[0].reset();
            modal.modal('hide');
            categories_datatables.ajax.reload(null, false); //update datables
            subCategoryTable.ajax.reload(false, null);
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

  $(document).on('click', '.deleteSubCategoriBtn', function(e) {
    e.preventDefault();

    let id_sub = $(this).attr('data-id');
    let url = "<?= base_url('admin/delete_sub_category'); ?>"

    Swal.fire({
      title: "Apakah anda yakin?",
      text: "Ingin Menghapus Sub Kategori!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.getJSON(url, {
          id_sub: id_sub
        }, function(response) {
          if (response.status == 1) {
            categories_datatables.ajax.reload(null, false);
            subCategoryTable.ajax.reload(null, false);
            toastr.success(response.msg);
          } else {
            toastr.error(response.msg);
          }
        });
      }
    });
  });

  // REORDER SUB CATEGORY
  $('#sub_category_table').find('tbody').sortable({
    update: function(e, ui) {
      $(this).children().each(function(index) {
        if ($(this).attr('data-ordering') != (index + 1)) {
          $(this).attr('data-ordering', (index + 1)).addClass('update');
        }
      });

      let positions = [];

      $('.update').each(function(index) {
        positions.push([$(this).attr('data-index'), $(this).attr('data-ordering')]);
        $(this).removeClass('update');
      });
      console.log(positions);
      let url = "<?= base_url('admin/reoder_sub_categories'); ?>";
      $.getJSON(url, {
        positions: positions
      }, function(response) {
        if (response.status == 1) {
          subCategoryTable.ajax.reload(null, false);
          toastr.success(response.msg);
        } else {
          subCategoryTable.ajax.reload(null, false);
          toastr.error(response.msg);
        }
      });
    }
  });
</script>
<?= $this->endSection(); ?>