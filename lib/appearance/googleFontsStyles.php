<?php

add_action('ci_styles', 'ciPrintFontStyles');
function ciPrintFontStyles() {
    function getFontFamily($key, $default) {
        return str_replace("+", " ", of_get_option($key, $default) );
    }

    $h1Family = getFontFamily('title_font_family', "Bree Serif");
    $h2Family = getFontFamily('heading_font_family', "Bree Serif");
    $widgetTitleFamily = getFontFamily('widget_title_font_family', "Open Sans");
    $bodyFamily = getFontFamily('body_font_family', "Open Sans");

    $h1Weight = of_get_option('title_font_weight', '400');
    $h2Weight = of_get_option('heading_font_weight', '400');
    $widgetTitleWeight = of_get_option('widget_title_font_weight', '700');
    $bodyWeight = of_get_option('body_font_weight', '400');

    $h1Fallback = of_get_option('title_font_fallback', 'Georgia, Garamond, sans-serif');
    $h2Fallback = of_get_option('heading_font_fallback', 'Georgia, Garamond, sans-serif');
    $widgetTitleFallback = of_get_option('widget_title_font_fallback', '"Helvetica Neue", Helvetica, Arial, sans-serif');
    $bodyFallback = of_get_option('body_font_fallback', '"Helvetica Neue", Helvetica, Arial, sans-serif'); ?>
    <!-- Font styles -->
    <style>
        body, html, div {
            font-family: "<?php echo $bodyFamily; ?>", <?php echo $bodyFallback; ?>;
            font-weight: <?php echo $bodyWeight; ?>;
        }
        h1, a.navbar-brand {
            font-family: "<?php echo $h1Family; ?>", <?php echo $h1Fallback; ?>;
            font-weight: <?php echo $h1Weight; ?>;
        }
        h2, h3, h4, h5, h6 {
            font-family: "<?php echo $h2Family; ?>", <?php echo $h2Fallback; ?>;
        }
        h2, h3 {
            font-weight: <?php echo $h2Weight; ?>;
        }
        .widget h3 {
            font-family: "<?php echo $widgetTitleFamily; ?>", <?php echo $widgetTitleFallback; ?>;
            font-weight: <?php echo $widgetTitleWeight; ?>;
        }
    </style>
<?php
}
