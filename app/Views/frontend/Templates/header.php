<header class="navigation">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light px-0">
      <a class="navbar-brand order-1 py-0" href="index.html">
        <img loading="prelaod" decoding="async" class="img-fluid" src="<?= base_url('blog_template/theme/images/logo.png') ?>" alt="Reporter Hugo">
      </a>
      <div class="navbar-actions order-3 ml-0 ml-md-4">
        <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation"> <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <form action="#!" class="search order-lg-3 order-md-2 order-3 ml-auto">
        <input id="search-query" name="s" type="search" placeholder="Search..." autocomplete="off">
      </form>
      <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
        <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
          <li class="nav-item"> <a class="nav-link" href="<?= base_url('/'); ?>">Home</a>
          </li>

          <?php foreach (get_parent_category() as $category) :  ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $category['kategori']; ?>
              </a>
              <div class="dropdown-menu">
                <?php foreach (get_sub_category_by_parent_category($category['id_kategori']) as $sub_kategory) :  ?>
                  <a class="dropdown-item" href="<?= base_url('category_posts/' . $sub_kategory['slug']); ?>"><?= $sub_kategory['sub_kategori']; ?></a>
                <?php endforeach; ?>
              </div>
            </li>
          <?php endforeach; ?>
          <li class="nav-item"> <a class="nav-link" href="contact.html">Contact</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>