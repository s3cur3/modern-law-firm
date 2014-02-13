<?php
$name = get_bloginfo('name');
$brandHTML = $name;
$imgURL = of_get_option('firm_logo', false);
if ($imgURL) {
    $brandHTML = "<img src=\"{$imgURL}\" alt=\"{$name}\" />";
}
?>
<header class="banner navbar navbar-default navbar-static-top" role="banner">
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
            if (has_nav_menu('landing_navigation')) :
                wp_nav_menu(array('theme_location' => 'landing_navigation', 'menu_class' => 'nav navbar-nav'));
            endif;
            ?>
        </nav>
    </div>
</header>
