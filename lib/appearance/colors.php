<?php

function ciGetColorTheme() {
    $theme = of_get_option('color_theme', 'blue_charcoal');
    if( isset($_GET['color']) ) {
        $theme = $_GET['color'];
    }


    $link = '#428bca';
    $name = '#27201D';
    $bg = '#eeeeee';
    $secondaryBG = '#27201D';
    $h2 = "#27201D";
    $h1 = "#27201D";
    $btn = '#428bca';
    $h2OnSecondary = "#ffffff";
    $navigationBar = "#f8f8f8";
    switch( $theme ) {
        case "red_charcoal":
            $link = '#A60304';
            $btn = $link;
            $h2OnSecondary = "#ffffff";
            break;
        case "green_charcoal":
            $link = '#20C033';
            $btn = $link;
            $h2OnSecondary = "#ffffff";
            break;
        case "orange_charcoal":
            $link = '#F66200';
            $btn = $link;
            $h2OnSecondary = "#ffffff";
            break;
        case "blue_green":
            $link = '#3FAFE9';
            $btn = '#50A038';
            $bg = '#ffffff';
            $h2 = $link;
            $h2OnSecondary = $h2;
            break;
        case "brown":
            $link = "#6871A5";//'#4E6094';
            $btn = '#C48851';
            $name = '#6B3010';
            $secondaryBG = '#3B3129';
            $bg = "#ffffff";
            $h2 = $btn;
            $h1 = $secondaryBG;
            $h2OnSecondary = $h2;
            break;
        case "royalblue":
            $link = '#418EBF';
            $name = '#17558C';
            $bg = '#e9f0f5';
            $secondaryBG = '#133663';
            $h2 = $link;
            $h1 = $secondaryBG;
            $btn = $link;
            $h2OnSecondary = $h2;
            break;
        case "purple":
            $link = '#B068C2';
            $name = '#390A74';
            $bg = '#EDE6ED';
            $secondaryBG = $name;
            $h2 = $link;
            $h1 = $name;
            $btn = $link;
            $h2OnSecondary = $h2;
            break;
        case "darkgreen":
            $link = '#0A8C00';
            $name = $link;
            $bg = '#CADBC5';
            $secondaryBG = "#002800";
            $h2 = $link;
            $h1 = $name;
            $btn = $link;
            $h2OnSecondary = $h2;
            break;
        case "multi":
            $link = '#45B29D';
            $name = '#E27A3F';
            $bg = '#ffffff';
            $secondaryBG = '#334D5C';
            $h2 = "#E27A3F";
            $h1 = "#45B29D";
            $btn = '#45B29D';
            $h2OnSecondary = $h2;
            break;

    }
    return array(
        'splash_color' => $link,
        'firm_name_color' => $name,
        'background_color' => $bg,
        'secondary_background_color' => $secondaryBG,
        'heading_color' => $h2,
        'page_title_color' => $h1,
        'button_color' => $btn,
        'heading_on_secondary_background' => $h2OnSecondary,
        'navigation_bar' => $navigationBar
    );
}


// Register colorpickers
add_action('customize_register', 'mlfCustomizeRegister');
function mlfCustomizeRegister($wp_customize)
{
    $defaultColors = ciGetColorTheme();
    $colors = array();
    $colors[] =
        array(
            'slug' => 'splash_color',
            'default' => $defaultColors['splash_color'],
            'label' => __('Link Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'button_color',
            'default' => $defaultColors['button_color'],
            'label' => __('Button Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'firm_name_color',
            'default' => $defaultColors['firm_name_color'],
            'label' => __('Firm Name Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'page_title_color',
            'default' => $defaultColors['page_title_color'],
            'label' => __('Page Title Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'heading_color',
            'default' => $defaultColors['heading_color'],
            'label' => __('Level 2 Heading Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'background_color',
            'default' => $defaultColors['background_color'],
            'label' => __('Background Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'secondary_background_color',
            'default' => $defaultColors['secondary_background_color'],
            'label' => __('Secondary Background Color', MLF_TEXT_DOMAIN)
        );
    $colors[] =
        array(
            'slug' => 'navigation_bar',
            'default' => $defaultColors['navigation_bar'],
            'label' => __('Navigation Bar Color', MLF_TEXT_DOMAIN)
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




add_action( 'ci_styles', 'mlfPrintCustomColorStyling' );
function mlfPrintCustomColorStyling() {
    /**
     * Gets the customized color for a particular use.
     * @param string $colorIdentifier The name of the color, as registered with the WordPress theme customizer
     * @return string The color, in the form "#xxxxxxx"
     */
    function mlfGetNormalizedColor($colorIdentifier) {
        $defaultColors = ciGetColorTheme();
        $clr = get_option($colorIdentifier);
        if( ($clr == "" || $clr == "#") && array_key_exists($colorIdentifier, $defaultColors) ) {
            $clr = $defaultColors[$colorIdentifier];
        }

        // Hack to keep this from being in the Customize options
        if( $colorIdentifier == 'heading_on_secondary_background' && !$clr ) {
            $clr = $defaultColors[$colorIdentifier];
        }

        if( $clr[0] !== "#" ) {
            $clr = "#" . $clr;
        }

        return $clr;
    }

    $splash = mlfGetNormalizedColor('splash_color');
    $firm_name = mlfGetNormalizedColor('firm_name_color');
    $background = mlfGetNormalizedColor('background_color');
    $secondaryBG = mlfGetNormalizedColor('secondary_background_color');
    $h1 = mlfGetNormalizedColor('page_title_color');
    $h2 = mlfGetNormalizedColor('heading_color');
    $h2OnSecondary = mlfGetNormalizedColor('heading_on_secondary_background');
    $btn = mlfGetNormalizedColor('button_color');
    $backgroundImg = of_get_option("full_screen_image_bg");
    $backgroundPattern = of_get_option("pattern_bg");
    $navigationBar = mlfGetNormalizedColor('navigation_bar');

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
            } else if( $backgroundPattern && $backgroundPattern != 'none' ) {
                $patternPath = get_template_directory_uri() . '/assets/img/patterns/'; ?>
                background-image: url('<?php echo $patternPath, $backgroundPattern; ?>.png');
                background-repeat: repeat;
                background-position: center center;<?php
            } ?>
        }

        .navbar-default {
            background-color: <?php echo $navigationBar; ?>;
            border-color: <?php echo mlfAdjustBrightness($navigationBar, -10); ?>;
        }

        .navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:hover, .navbar-default .navbar-nav>.active>a:focus, .dropdown-menu>.active>a, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>a:focus {
            background: <?php echo $splash; ?>;
            color: #fff;
        }

        h1 {
            color: <?php echo $h1 ?>;
        }
        h2 {
            color: <?php echo $h2 ?>;
        }
        .carousel-caption h2 {
            color: #fff;
        }
        .inverted h2 {
            color: <?php echo $h2OnSecondary; ?>;
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
            background-color: <?php echo $btn; ?>;
            border-color: <?php echo mlfAdjustBrightness($btn, -20) ?>; /* slightly darker */
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary, input[type="submit"]:hover, button[type="submit"]:hover, input[type="submit"]:focus, button[type="submit"]:focus, form input[type="submit"]:hover, form input[type="submit"]:focus {
            background-color: <?php echo mlfAdjustBrightness($btn, -18) ?>;
            border-color: <?php echo mlfAdjustBrightness($btn, -35) ?>;
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




function mlfAddEditorStyles() {
    add_editor_style( 'assets/css/editor-colors.php' );
}
add_action( 'init', 'mlfAddEditorStyles' );


