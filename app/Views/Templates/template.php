<!DOCTYPE html>
<html>

<head>
  <!-- Basic Page Info -->
  <meta charset="utf-8" />
  <title><?= $title; ?></title>

  <!-- Site favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('frontend/vendors/images/apple-touch-icon.png'); ?>" />
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('frontend/vendors/images/favicon-32x32.png'); ?>" />
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('frontend/vendors/images/favicon-16x16.png'); ?>" />

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('frontend/vendors/styles/core.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url('frontend/vendors/styles/icon-font.min.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url('frontend/vendors/styles/style.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url('ijabo/ijaboCropTool.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('frontend/src/styles/toastr.min.css'); ?>">
  <?= $this->renderSection('stylesheets'); ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258" crossorigin="anonymous"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-GBZ3SGGX85");
  </script>
  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        "gtm.start": new Date().getTime(),
        event: "gtm.js"
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != "dataLayer" ? "&l=" + l : "";
      j.async = true;
      j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
  </script>
  <!-- End Google Tag Manager -->
</head>

<body>

  <!-- <div class="pre-loader">
    <div class="pre-loader-box">
      <div class="loader-logo">
        <img src="<?= base_url('frontend/vendors/images/deskapp-logo.svg'); ?>" alt="" />
      </div>
      <div class="loader-progress" id="progress_div">
        <div class="bar" id="bar1"></div>
      </div>
      <div class="percent" id="percent1">0%</div>
      <div class="loading-text">Loading...</div>
    </div>
  </div> -->
  <?= $this->include('Templates/header'); ?>

  <?= $this->include('Templates/right_sidebar'); ?>

  <?= $this->include('Templates/left_sidebar'); ?>
  <div class="mobile-menu-overlay"></div>

  <div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
      <div class="min-height-200px">
        <?= $this->renderSection('contentPage'); ?>
      </div>
      <div class="footer-wrap pd-20 mb-20 card-box">
        <p class="mb-0">
          &copy; Copyright
          <script>
            document.write(new Date().getFullYear());
          </script>
          Blog App All Right reserved.
        </p>

      </div>
    </div>
  </div>
  <!-- welcome modal start -->

  <!-- welcome modal end -->
  <!-- js -->
  <script src="<?= base_url('frontend/src/scripts/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('ijabo/ijaboCropTool.min.js'); ?>"></script>
  <script src="<?= base_url('frontend/src/scripts/toastr.min.js'); ?>"></script>
  <?= $this->renderSection('script'); ?>
  <script src="<?= base_url('frontend/vendors/scripts/core.js'); ?>"></script>
  <script src="<?= base_url('frontend/vendors/scripts/script.min.js'); ?>"></script>
  <script src="<?= base_url('frontend/vendors/scripts/process.js'); ?>"></script>
  <script src="<?= base_url('frontend/vendors/scripts/layout-settings.js'); ?>"></script>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
</body>

</html>