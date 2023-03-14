<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap 4.3.1 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/assets/css/vendor/bootstrap.min.css">
  <!-- styles -->
  <link rel="stylesheet" href="<?= base_url()?>/public/assets/css/styles.min.css">
  <!-- simplebar styles -->
  <link rel="stylesheet" href="<?= base_url()?>/public/assets/css/vendor/simplebar.css">
  <!-- tiny-slider styles -->
  <link rel="stylesheet" href="<?= base_url()?>/public/assets/css/vendor/tiny-slider.css">
  <!-- favicon -->
  <link rel="icon" href="<?= base_url()?>/public/assets/images/favicon.ico">
  <title>Arta Kusuma Hernanda | Profile</title>
</head>
<body>

  <!-- PAGE LOADER -->
  <div class="page-loader">
    <div class="page-loader-info">
      <p class="page-loader-info-title">artakusuma.com</p>

      <p class="page-loader-info-text">Loading...</p>
    </div>
    
    <div class="page-loader-indicator loader-bars">
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
    </div>
  </div>
  <!-- /PAGE LOADER -->

  <!-- CONTENT GRID -->
  <div class="content-grid">

    <?= $this->renderSection('isi') ?>

  </div>
  <!-- /CONTENT GRID -->

  <!-- POPUP VIDEO -->
  <div class="popup-video">
    <div class="popup-close-button popup-video-trigger">
      <svg class="popup-close-button-icon icon-cross">
        <use xlink:href="#svg-cross"></use>
      </svg>
    </div>
    <div class="iframe-wrap">
      <iframe src="https://www.youtube.com/embed/6ErE27RNLDQ?start=200" allowfullscreen></iframe>
    </div>
  </div>
  <!-- /POPUP VIDEO -->

<!-- app -->
<script src="<?= base_url()?>/public/assets/js/utils/app.js"></script>
<!-- page loader -->
<script src="<?= base_url()?>/public/assets/js/utils/page-loader.js"></script>
<!-- simplebar -->
<script src="<?= base_url()?>/public/assets/js/vendor/simplebar.min.js"></script>
<!-- liquidify -->
<script src="<?= base_url()?>/public/assets/js/utils/liquidify.js"></script>
<!-- XM_Plugins -->
<script src="<?= base_url()?>/public/assets/js/vendor/xm_plugins.min.js"></script>
<!-- tiny-slider -->
<script src="<?= base_url()?>/public/assets/js/vendor/tiny-slider.min.js"></script>

<!-- global.hexagons -->
<script src="<?= base_url()?>/public/assets/js/global/global.hexagons.js"></script>
<!-- global.tooltips -->
<script src="<?= base_url()?>/public/assets/js/global/global.tooltips.js"></script>

<!-- global.popups -->
<script src="<?= base_url()?>/public/assets/js/global/global.popups.js"></script>
<!-- header -->
<script src="<?= base_url()?>/public/assets/js/header/header.js"></script>
<!-- sidebar -->
<script src="<?= base_url()?>/public/assets/js/sidebar/sidebar.js"></script>
<!-- content -->
<script src="<?= base_url()?>/public/assets/js/content/content.js"></script>
<!-- form.utils -->
<script src="<?= base_url()?>/public/assets/js/form/form.utils.js"></script>
<!-- SVG icons -->
<script src="<?= base_url()?>/public/assets/js/utils/svg-loader.js"></script>


</body>
</html>