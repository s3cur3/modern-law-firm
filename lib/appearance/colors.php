<?php

// Register colorpickers
add_action('customize_register', 'mlfCustomizeRegister');
function mlfCustomizeRegister($wp_customize)
{
    $colors = array();
    $colors[] =
        array(
            'slug' => 'splash_color',
            'default' => '#428bca',
            'label' => __('Splash Color', 'Modern_Law_Firm')
        );
    $colors[] =
        array(
            'slug' => 'firm_name_color',
            'default' => '#222222',
            'label' => __('Firm Name Color', 'Modern_Law_Firm')
        );

    $colors[] =
        array(
            'slug' => 'background_color',
            'default' => '#eeeeee',
            'label' => __('Background Color', 'Modern_Law_Firm')
        );
    $colors[] =
        array(
            'slug' => 'secondary_background_color',
            'default' => '#222222',
            'label' => __('Secondary Background Color', 'Modern_Law_Firm')
        );

    foreach ($colors as $color) {
        // SETTINGS
        $wp_customize->add_setting($color['slug'], array('default' => $color['default'], 'type' => 'option', 'capability' => 'edit_theme_options'));

        // CONTROLS
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $color['slug'], array('label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'])));
    }
}


/**
 * @param $hex string A hexidecimal color (like "#ffffff")
 * @param $steps int The amount to lighten or darken the color. Should be between -255 and 255,
 *                   with negative colors darkening and positive colors lightening.
 * @return string The hex value of the darkened/lightened color, beginning with "#"
 */
function mlfAdjustBrightness($hex, $steps) {
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + ($r * ($steps / 255))));
    $g = max(0,min(255,$g + ($g * ($steps / 255))));
    $b = max(0,min(255,$b + ($b * ($steps / 255))));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}




function mlfPrintCustomColorStyling() {
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
    <!-- From colors.php -->
    <style>
        body {
            background: <?php echo $background; ?>;
<?php
            if( $backgroundImg ) { ?>
                background: url(<?php echo $backgroundImg; ?>) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover; <?php
            } else if( $backgroundPattern ) {
                $patternPath = get_template_directory_uri() . '/assets/img/patterns/'; ?>
                background-image: url('<?php echo $patternPath, $backgroundPattern; ?>');
                background-repeat: repeat;
                background-position: center center;<?php
            } ?>
        }

        .navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:hover, .navbar-default .navbar-nav>.active>a:focus, .dropdown-menu>.active>a, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>a:focus {
            background: <?php echo $splash; ?>;
            color: #fff;
        }

        a, .individual-post .meta a:hover {
            color: <?php echo $splash; ?>;
        }
        a:hover, a:focus {
            color: <?php echo mlfAdjustBrightness($splash, -30) ?>;
        }

        .navbar-default .navbar-brand {
            color: <?php echo $firm_name; ?>
        }

        .nsu_widget, footer, .inverted, .carousel-caption.left, .carousel-caption.right {
            background: <?php echo $secondaryBG; ?>;
            color: #fff;
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

        ul.social-list li a, .individual-post .meta a {
            color: <?php echo $secondaryBG; ?>;
        }

        @media (max-width: 768px) {
            .carousel-caption.left, .carousel-caption.right {
                background: transparent;
            }
        }
    </style>
<?php
}
add_action( 'wp_head', 'mlfPrintCustomColorStyling' );




function mlfAddEditorStyles() {
    add_editor_style( 'assets/css/editor-colors.php' );
}
add_action( 'init', 'mlfAddEditorStyles' );


