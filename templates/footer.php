<!-- templates/footer.php -->
<?php

if ( is_active_sidebar( 'sidebar-footer' ) ) { ?>
    <footer>
        <div class="container">
            <div class="row widget-container">
                <?php dynamic_sidebar('sidebar-footer'); ?>
            </div>
        </div>
    </footer> <?php
} ?>

<?php
$disclaimerWidth = "8";
if( of_get_option('disclaimer_full_width', false) ) {
    $disclaimerWidth = "12";
}
?>
<div class="container content-info" role="contentinfo">
    <div class="row">
        <div class="col-lg-<?php echo $disclaimerWidth; ?>"><?php
            mlfPrintDisclaimer();

            if(of_get_option('mlf_copyright_text', true) && of_get_option('mlf_theme_credit', true)) { ?>
                <p>&copy; <?php echo date('Y') . " " . do_shortcode(get_bloginfo('name')); ?> | <?php ciPrintThemeCredit(); ?></p> <?php
            } elseif(of_get_option('mlf_copyright_text', true)) { ?>
                <p>&copy; <?php echo date('Y') . " " . do_shortcode(get_bloginfo('name')); ?></p> <?php
            } elseif(of_get_option('mlf_theme_credit', true)) { ?>
                <p><?php ciPrintThemeCredit(); ?></p> <?php
            } ?>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
<script>
    jQuery(document).ready(function(){
        jQuery("a[rel^='prettyPhoto']").prettyPhoto();
    });
</script>
<?php
if( of_get_option('mlf_demo_site', false) ) { ?>
    <style>
        #frontend-color-picker {
            position: fixed;
            left: 0;
            top: 30%;
            background-color: #fff;
            padding: 5px;
            border-radius: 0 4px 4px 0;
            z-index: 100;
            box-shadow: 0 2px 9px 2px rgba(0,0,0,0.18);
            width: 200px;
        }
        #frontend-color-picker .close {
            text-align: right;
        }
        #frontend-color-picker h4 {
            font-family: "Open Sans", sans-serif;
            font-size: 0.8em;
            text-transform: uppercase;
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
            width: 100%;
        }
        #frontend-color-picker .input {
            margin-bottom: 25px;
        }
        #frontend-color-picker ul {
            margin-bottom: 0;
        }
        #frontend-color-picker li {
            margin-bottom: 5px;
            display: inline;
            float: left;
            margin-left: 5px;
            /*width: 26px;
            height: 26px;
            overflow: hidden;*/
        }
        #frontend-color-picker li img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            -webkit-box-shadow: 0 0 2px #000;
            -moz-box-shadow: 0 0 2px #000;
            box-shadow: 0 0 2px #000;
        }
    </style>
    <div id="frontend-color-picker">
        <div class="close" onclick="jQuery('#frontend-color-picker').hide()">&times;</div>
        <h4>Choose a layout</h4>
        <div class="input">
            <select id="layout" name="layout">
                <option value="full">Full-width</option>
                <option value="normal">Normal page</option>
            </select>
        </div>
        <div id="background-select-container">
            <h4>Choose a background</h4>
            <div class="input">
                <select id="background" name="background">
                    <option value="white">Solid white</option>
                    <option value="pattern">Subtle pattern</option>
                    <option value="image">Full-screen image</option>
                </select>
            </div>
        </div>
        <h4>Choose a color scheme</h4>
        <ul class="no-bullet"> <?php
            $colorPath = get_template_directory_uri() . '/assets/img/colors/';
            $colors = array(
                'blue_charcoal' => $colorPath . 'blue_charcoal.png',
                'blue_green' => $colorPath . 'blue_green.png',
                'brown' => $colorPath . 'brown.png',
                'royalblue' => $colorPath . 'royalblue.png',
                'purple' => $colorPath . 'purple.png',
                'darkgreen' => $colorPath . 'darkgreen.png',
                'multi' => $colorPath . 'multi.png',
                'red_charcoal' => $colorPath . 'red_charcoal.png',
                'green_charcoal' => $colorPath . 'green_charcoal.png',
                'orange_charcoal' => $colorPath . 'orange_charcoal.png',
            );
            $url = get_permalink();
            foreach( $colors as $color => $imgURL ) {
                $urlWithColor = $url . "?color=" . $color;
                echo "<li><a href=\"{$urlWithColor}\" class=\"no-color-link\"><img src=\"{$imgURL}\" alt=\"{$color}\"></a></li>";
            } ?>
        </ul>
    </div>
    <div id="imgPreload">
    </div>
    <?php
}