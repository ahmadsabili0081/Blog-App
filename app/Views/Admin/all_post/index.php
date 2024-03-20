<?= $this->extend('Templates/template'); ?>

<?= $this->section('contentPage'); ?>
<div class="page-header">
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="title">
        <h4>Semua Postingan</h4>
      </div>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin'); ?>">Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Semua Postingan
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
<div class="row">
  <div class="col-md-12 mb-4">
    <div class="card card-box">
      <div class="card-header">
        <div class="clearfix">
          <div class="pull-left">Semua Postingan</div>
          <div class="pull-right"></div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-borderless table-hover table-striped" id="posts-table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Gambar</th>
              <th scope="col">Judul Postingan</th>
              <th scope="col">Kategori</th>
              <th scope="col">Visibilitas</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('stylesheets'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?= base_url('frontend/src/plugins/datatables/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/src/plugins/datatables/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('frontend/package/dist/sweetalert2.min.css'); ?>">
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?= base_url('frontend/src/plugins/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('frontend/package/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= base_url('frontend/src/plugins/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('frontend/src/plugins/datatables/js/dataTables.responsive.min.js'); ?>"></script>
<script>
  let postsTable = $('table#posts-table').DataTable({
    scrollCollapse: true,
    responsive: true,
    autoWidth: true,
    processing: true,
    serverSide: true,
    ajax: "<?= base_url('admin/posts/get_posts'); ?>",
    "dom": "IBfrtip",
    info: true,
    fnCreatedRow: function(row, data, index) {
      console.log(index);
      $('td', row).eq(0).html(index + 1);
    },
    columDefs: [{
      orderable: false,
      targets: [0, 1, 2, 3, 4, 5]
    }],
  });

  $(document).on('click', '.btnDelete', function(e) {
    e.preventDefault();
    let form = this;
    let url = "<?= base_url('admin/posts/delete_posts'); ?>"
    let id_posts = $(form).data('id');
    Swal.fire({
      title: "Apakah anda yakin?",
      text: "Ingin Menghapus Postingan!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.getJSON(url, {
          id_posts: id_posts
        }, function(response) {
          if (response.status == 1) {
            postsTable.ajax.reload(null, false);
            toastr.success(response.msg);
          } else {
            toastr.error(response.msg);
          }
        });
      }
    });
  });
</script>
<?= $this->endSection(); ?>