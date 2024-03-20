<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
  <meta charset="utf-8">
  <title><?= isset($page_title) ? $page_title : 'Halaman Baru'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
  <meta name="description" content="This is meta description">
  <meta name="<?= csrf_token(); ?>" content="<?= csrf_hash(); ?>">
  <?= $this->renderSection('page_meta'); ?>
  <link rel="icon" href="<?= base_url('frontend/images/blog/default.png'); ?>">
  <meta name="author" content="Themefisher">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">

  <!-- # Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- # CSS Plugins -->
  <link rel="stylesheet" href="<?= base_url('blog_template/theme/plugins/bootstrap/bootstrap.min.css'); ?>">

  <!-- # Main Style Sheet -->
  <link rel="stylesheet" href="<?= base_url('blog_template/theme/css/style.css'); ?>">
</head>

<body>

  <?= $this->include('frontend/Templates/header'); ?>

  <main>
    <section class="section">
      <div class="container">
        <?= $this->renderSection('content'); ?>
      </div>
    </section>
  </main>

  <?= $this->include('frontend/Templates/footer'); ?>


  <!-- # JS Plugins -->
  <script src="<?= base_url('blog_template/theme/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('blog_template/theme/plugins/bootstrap/bootstrap.min.js') ?> "></script>

  <!-- Main Script -->
  <script src="<?= base_url('blog_template/theme/js/script.js'); ?> "></script>

</body>

</html>