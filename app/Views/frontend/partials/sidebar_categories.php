<div class="widget">
  <h2 class="section-title mb-3">Categories</h2>
  <div class="widget-body">
    <ul class="widget-list">
      <?php if (count(get_sidebar_categories()) > 0) :  ?>
        <?php foreach (get_sidebar_categories() as $category) :  ?>
          <li><a href="<?= base_url('Blog/' . $category['slug']); ?>"><?= $category['sub_kategori']; ?><span class="ml-auto"> (<?= get_sidebar_categories_by_id($category['id_kategori']); ?>)</span></a></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</div>