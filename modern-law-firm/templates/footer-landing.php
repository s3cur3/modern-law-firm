<div class="container content-info col-sm-8" role="contentinfo">
    <p class="text-center"><a href="<?php echo site_url(); ?>">Continue to <?php echo bloginfo('name'); ?></a></p>
    <?php mlfPrintDisclaimer(); ?>
</div>

<?php wp_footer(); ?>
<script>
    jQuery(document).ready(function(){
        jQuery("a[rel^='prettyPhoto']").prettyPhoto();
    });
</script>
