<?php

$showSlider = mlfGetNormalizedMeta('top_img_slider', false);
$additionalClass = "landing-page";
if( $showSlider ) {
    $additionalClass .= " has-top-slider";
}

get_template_part('templates/head');

?>
<body <?php body_class($additionalClass); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', MLF_TEXT_DOMAIN); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar-landing');
    } else {
      get_template_part('templates/header');
    }
  ?>

  <div class="wrap container" role="document">
    <div class="content row">
      <main class="main <?php echo roots_main_class(); ?> col-sm-8" role="main">
          <div class="pad">
            <?php include roots_template_path(); ?>
          </div>
      </main><!-- /.main -->
    </div><!-- /.content -->
  </div><!-- /.wrap -->

  <?php get_template_part('templates/footer-landing'); ?>

</body>
</html>
