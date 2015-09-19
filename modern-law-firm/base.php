<?php

$showSlider = mlfGetNormalizedMeta('top_img_slider', false);
$additionalClass = "";
if( $showSlider ) {
    $additionalClass = " has-top-slider";
}

get_template_part('templates/head');



if( of_get_option('navbar_fixed', false) ) {
    $additionalClass .= "has-fixed-navbar";
}
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
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>

  <?php
  if( $showSlider ) {
      $sliderCat = mlfGetNormalizedMeta('top_img_slider_cat_string', '');
      echo mlfGetSliderHTML($sliderCat, 10, true, MLF_SIZE_LG);
  }
  ?>

  <div class="wrap container" role="document">
    <div class="content row">
      <main class="main <?php echo roots_main_class(); ?>" role="main">
          <div class="pad">
            <?php include roots_template_path(); ?>
          </div>
      </main><!-- /.main -->
      <?php if( roots_display_sidebar() ) : ?>
        <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
          <?php include roots_sidebar_path(); ?>
        </aside><!-- /.sidebar -->
      <?php endif; ?>
    </div><!-- /.content -->
  </div><!-- /.wrap -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
