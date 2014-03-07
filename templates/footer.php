<footer>
    <div class="container">
        <div class="row widget-container">
            <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
    </div>
</footer>
<div class="container content-info" role="contentinfo">
    <div class="row">
        <div class="col-lg-8">
            <?php mlfPrintDisclaimer(); ?>
            <p>&copy; <?php echo date('Y'); ?> <?php echo do_shortcode(get_bloginfo('name')); ?> | <?php ciPrintThemeCredit(); ?></p>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
<script>
    jQuery(document).ready(function(){
        jQuery("a[rel^='prettyPhoto']").prettyPhoto();
    });
</script>
