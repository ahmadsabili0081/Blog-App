<div class="modal fade" id="edit_sub_categori_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="edit_sub_kategori" action="<?= base_url('admin/sub_edit_sub_category'); ?>" method="post">
      <?= csrf_field(); ?>
      <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
      <input type="hidden" name="id_sub">
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
          <label for="">Kategori</label>
          <select name="id_kategori" id="" class="form-control">
            <option value="">--Pilih Kategori--</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Sub Kategori</label>
          <input type="text" class="form-control" id="sub_kategori_value" name="sub_kategori" placeholder="Sub Kategori">
          <small class="text-danger text_error sub_kategori_error"></small>
        </div>
        <div class="form-group">
          <label for=""><b>Deskripsi</b></label>
          <textarea name="description" id="" class="form-control"></textarea>
          <small class="text-danger text_error description_error"></small>
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