<div class="left-side-bar">
  <div class="brand-logo">
    <a href="index.html">
      <img src="<?= base_url('frontend/vendors/images/deskapp-logo.svg'); ?>" alt="" class="dark-logo" />
      <img src="<?= base_url('frontend/vendors/images/deskapp-logo-white.svg'); ?>" alt="" class="light-logo" />
    </a>
    <div class="close-sidebar" data-toggle="left-sidebar-close">
      <i class="ion-close-round"></i>
    </div>
  </div>
  <div class="menu-block customscroll">
    <div class="sidebar-menu">
      <ul id="accordion-menu">
        <li>
          <a href="<?= base_url('admin'); ?>" class="dropdown-toggle no-arrow <?= current_root_name() == 'admin.home'  ? 'active' : ''; ?>">
            <span class="micon dw dw-home"></span><span class="mtext">Home</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/categories'); ?>" class="dropdown-toggle no-arrow <?= current_root_name() == 'admin.categories' ? 'active' : ''; ?>">
            <span class="micon dw dw-list"></span><span class="mtext">Kategori</span>
          </a>
        </li>
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle <?= (current_root_name() == 'admin.new_posts' || current_root_name() == 'admin.all_posts' ? 'active' : '');  ?>">
            <span class="micon dw dw-newspaper"></span><span class="mtext">Postingan</span>
          </a>
          <ul class="submenu">
            <li><a href="<?= base_url('admin/posts/all_posts'); ?>" class="<?= current_root_name() == 'admin.all_posts' ? 'active' : ''; ?>">Semua Postingan</a></li>
            <li><a href="<?= base_url('admin/posts/new_posts') ?>" class="<?= current_root_name() == 'admin.new_posts' ? 'active' : ''; ?>">Tambah Postingan</a></li>
          </ul>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <div class="sidebar-small-cap">Settings</div>
        </li>

        <li>
          <a href="<?= base_url('admin/profile'); ?>" class="dropdown-toggle no-arrow <?= current_root_name() == 'admin.profile' ? 'active' : ''; ?>">
            <span class="micon dw dw-user"></span><span class="mtext">Profile</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/settings'); ?>" class="dropdown-toggle no-arrow <?= current_root_name() == 'admin.settings' ? 'active' : ''; ?>">
            <span class="micon dw dw-settings"></span><span class="mtext">Settings</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>