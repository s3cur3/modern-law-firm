<?php
$showTitle = mlfGetNormalizedMeta( 'show_page_title', true );
if( $showTitle ) { ?>
    <div class="page-header">
        <?php printBreadcrumbs(); ?>
        <h1>
            <?php echo roots_title(); ?>
        </h1>
    </div> <?php
} else { ?>
    <div class="buffer"></div> <?php
}
if( has_post_thumbnail() ) {
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), array( 2048, 2048 ) );
    echo '<a class="featured-img" href="' . $large_image_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="prettyPhoto">';
    the_post_thumbnail( array( 686, 1000 ) );
    echo '</a>';
}
?>