<?= $this->extend('frontend/Templates/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
  <div class="col-12">
    <h1 class="mb-4 border-bottom border-primary d-inline-block"><?= $category['sub_kategori']; ?></h1>
  </div>
  <div class="col-lg-8 mb-5 mb-lg-0">
    <div class="row">
      <?php foreach ($posts as $post) :  ?>
        <div class="col-md-6 mb-4">
          <article class="card article-card article-card-sm h-100">
            <a href="<?= base_url('read_post/' . $post['slug']); ?> ">
              <div class="card-image">
                <div class="post-info"> <span class="text-uppercase"><?= date_formatter($post['created_at']); ?></span>
                  <span class="text-uppercase"><?= get_reading_time($post['content']); ?></span>
                </div>
                <img loading="lazy" decoding="async" src="<?= base_url('frontend/images/posts_images/' . $post['featured_image']); ?>" alt="Post Thumbnail" class="w-100" width="420" height="280">
              </div>
            </a>
            <div class="card-body px-0 pb-0">
              <h2><a class="post-title" href="article.html"><?= $post['post_title']; ?></a></h2>
              <p class="card-text"><?= lates_limit_words($post['content']); ?></p>
              <div class="content"> <a class="read-more-btn" href="<?= base_url('read_post/' . $post['slug']); ?> ">Read Full Article</a>
              </div>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="widget-blocks">
      <div class="row">
        <div class="col-lg-12">
          <div class="widget">
            <div class="widget-body">
              <img loading="lazy" decoding="async" src="images/author.jpg" alt="About Me" class="w-100 author-thumb-sm d-block">
              <h2 class="widget-title my-3">Hootan Safiyari</h2>
              <p class="mb-3 pb-2">Hello, I’m Hootan Safiyari. A Content writter, Developer and Story teller. Working as a Content writter at CoolTech Agency. Quam nihil …</p> <a href="about.html" class="btn btn-sm btn-outline-primary">Know
                More</a>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-6">
          <div class="widget">
            <h2 class="section-title mb-3">Recommended</h2>
            <div class="widget-body">
              <div class="widget-list">
                <?php if (count(get_random_posts()) > 0) : ?>
                  <?php foreach (get_random_posts() as $random_post) :  ?>
                    <a class="media align-items-center" href="<?= base_url('post/' . $random_post['slug']); ?>">
                      <img loading="lazy" decoding="async" src="<?= base_url('frontend/images/posts_images/' . $random_post['featured_image']); ?>" alt="Post Thumbnail" class="w-100">
                      <div class="media-body ml-3">
                        <h3 style="margin-top:-5px"><?= $random_post['post_title'] ?></h3>
                        <p class="mb-0 small"><?= limit_words($random_post['content'], 6); ?></p>
                      </div>
                    </a>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-6">
          <?= $this->include('frontend/partials/sidebar_categories'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>