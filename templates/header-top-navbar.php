<?php
$name = get_bloginfo('name');
$brandHTML = $name;
$imgURL = of_get_option('firm_logo', false);
$svgURL = of_get_option('svg_logo', false);
if( $imgURL ) {
    $brandHTML = "<img src=\"{$imgURL}\" alt=\"{$name}\" />";
    if( $svgURL ) {
        $width = of_get_option('svg_logo_width', '300');
        $height = of_get_option('svg_logo_height', '37');
        /*$brandHTML = "<svg width=\"{$width}\" height=\"{$height}\">" .
                          "<image xlink:href=\"{$svgURL}\" src=\"{$imgURL}\" width=\"{$width}\" height=\"{$height}\" />" .
                     "</svg>";*/
        $brandHTML = "<img src=\"{$svgURL}\" onerror=\"this.onerror=null; this.src='{$imgURL}'\" width=\"{$width}\" height=\"{$height}\">";
    }
}

$navbarType = "static";
if( of_get_option('navbar_fixed', false) ) {
    $navbarType = "fixed";
}

?>
<header class="banner navbar navbar-default navbar-<?php echo $navbarType; ?>-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo home_url(); ?>/"><?php echo $brandHTML; ?></a>
        </div>

        <nav class="collapse navbar-collapse" role="navigation">
            <?php
            if( has_nav_menu('primary_navigation') ) {
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
            }
            ?>
        </nav>
    </div>
</header>
