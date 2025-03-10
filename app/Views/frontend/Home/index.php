<?= $this->extend('frontend/Templates/template'); ?>
<?= $this->section('page_meta'); ?>
<meta name="robots" content="index,follow" />
<meta name="title" content="<?= get_settings()['blog_title']; ?>">
<meta name="description" content="<?= get_settings()['blog_meta_keywords'] ?>" />
<meta name="author" content="<?= get_settings()['blog_title']; ?>" />
<link rel="canonical" href="<?= base_url(); ?>" />
<meta property="og:title" content="<?= get_settings()['blog_title']; ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?= get_settings()['blog_meta_keywords']; ?>" />
<meta property="og:url" content="<?= base_url(); ?>" />
<meta property="og:image" content="<?= base_url('frontend/images/blog/' . get_settings()['blog_logo']); ?>" />

<meta name="twitter:domain" content="<?= base_url(); ?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" property="og:title" itemprop="name" content="<?= get_settings()['blog_title']; ?>">
<meta name="twitter:description" property="og:description" itemprop="description" content="<?= get_settings()['blog_meta_keywords'] ?>">

<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row no-gutters-lg">
  <div class="col-12">
    <h2 class="section-title">Latest Articles</h2>
  </div>
  <div class="col-lg-8 mb-5 mb-lg-0">
    <div class="row">
      <div class="col-12 mb-4">
        <article class="card article-card">
          <a href="<?= base_url('post/' . get_latest_post()->slug); ?>">
            <div class="card-image">
              <div class="post-info"> <span class="text-uppercase"><?= date_formatter(get_latest_post()->created_at); ?></span>
                <span class="text-uppercase"><?= get_reading_time(get_latest_post()->content) ?></span>
              </div>
              <img loading="lazy" decoding="async" src="<?= base_url('frontend/images/posts_images/' . get_latest_post()->featured_image); ?>" alt="Post Thumbnail" class="w-100">
            </div>
          </a>
          <div class="card-body px-0 pb-1">
            <h2 class="h1"><a class="post-title" href="<?= base_url('post/' . get_latest_post()->slug) ?>"><?= get_latest_post()->post_title; ?>.</a></h2>
            <p class="card-text"><?= lates_limit_words(get_latest_post()->content); ?></p>
            <div class="content"> <a class="read-more-btn" href="<?= base_url('post/' . get_latest_post()->slug) ?>">Read Full Article</a>
            </div>
          </div>
        </article>
      </div>
      <?php if (count(get_latest_6_posts()) > 0) :  ?>
        <?php foreach (get_latest_6_posts() as $post) :  ?>
          <div class="col-md-6 mb-4">
            <article class="card article-card article-card-sm h-100">
              <a href="<?= base_url('post/' . $post['slug']); ?>">
                <div class="card-image">
                  <div class="post-info"> <span class="text-uppercase"><?= date_formatter($post['created_at']); ?></span>
                    <span class="text-uppercase"><?= get_reading_time($post['content']); ?></span>
                  </div>
                  <img loading="lazy" decoding="async" src="<?= base_url('frontend/images/posts_images/' . $post['featured_image']); ?>" alt="Post Thumbnail" class="w-100">
                </div>
              </a>
              <div class="card-body px-0 pb-0">
                <h2><a class="post-title" href="<?= base_url('post/' . $post['slug']); ?>"><?= $post['post_title']; ?></a></h2>
                <p class="card-text"><?= limit_words($post['content'], 8); ?></p>
                <div class="content"> <a class="read-more-btn" href="<?= base_url('post/' . $post['slug']); ?>">Read Full Article</a>
                </div>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
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
            <h2 class="section-title mb-3">Random Posts</h2>
            <div class="widget-body">
              <div class="widget-list">
                <?php if (count(get_random_posts()) > 0) : ?>
                  <?php foreach (get_random_posts() as $random_posts) :  ?>
                    <a class="media align-items-center" href="<?= base_url('post/' . $random_posts['slug']); ?>">
                      <img loading="lazy" decoding="async" src="<?= base_url('frontend/images/posts_images/' . $random_posts['featured_image']); ?>" alt="Post Thumbnail" class="w-100">
                      <div class="media-body ml-3">
                        <h3 style="margin-top:-5px"><?= $random_posts['post_title']; ?></h3>
                        <p class="mb-0 small"><?= limit_words($random_posts['content'], 6); ?></p>
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