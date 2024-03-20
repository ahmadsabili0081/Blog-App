<div class="modal fade editCategory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="update_categories" action="<?= base_url('admin/update_categories'); ?>" method="post">
      <?= csrf_field(); ?>
      <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
      <input type="hidden" name="id_kategori">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">
          Large modal
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Nama Kategori</label>
          <input type="text" class="form-control" id="kategori_value" name="kategori" placeholder="Nama Kategori">
          <small class="text-danger text_error kategori_error"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Tutup
        </button>
        <button type="submit" class="btn btn-primary action">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>