<?php
header("Content-type: text/css; charset: UTF-8");
define('WP_USE_THEMES', false);
require('../../../../../../wp-load.php');

$splash = get_option('splash_color');
$firm_name = get_option('firm_name_color');
$background = get_option('background_color');
$secondaryBG = get_option('secondary_background_color');
$backgroundImg = of_get_option("full_screen_image_bg");
$backgroundPattern = of_get_option("pattern_bg");
//$_color = get_option('_color');

// Correct weirdness from WP
if( $splash == "" ) $splash = "#428bca";
if( $firm_name == "" ) $firm_name = "#222222";
if( $background == "" ) $background = "#eeeeee";
if( $secondaryBG == "" ) $secondaryBG = "#222222";

if( $splash[0] !== "#" ) $splash = "#" . $splash;
if( $firm_name[0] !== "#" ) $firm_name = "#" . $firm_name;
if( $background[0] !== "#" ) $background = "#" . $background;
if( $secondaryBG[0] !== "#" ) $secondaryBG = "#" . $secondaryBG;

?>
/* From colors.php */
a {
    color: <?php echo $splash; ?>;
}

.inverted {
    background: <?php echo $secondaryBG; ?>;
    color: #fff;
}

a:hover, a:focus {
    color: <?php echo mlfAdjustBrightness($splash, -30) ?>;
}

.btn-primary, input[type="submit"], button[type="submit"] {
    color: #fff;
    background-color: <?php echo $splash ?>;
    border-color: <?php echo mlfAdjustBrightness($splash, -20) ?>; /* slightly darker */
}

.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary, input[type="submit"]:hover, button[type="submit"]:hover, input[type="submit"]:focus, button[type="submit"]:focus, form input[type="submit"]:hover, form input[type="submit"]:focus {
    background-color: <?php echo mlfAdjustBrightness($splash, -18) ?>;
    border-color: <?php echo mlfAdjustBrightness($splash, -35) ?>;
    color: #fff;
}