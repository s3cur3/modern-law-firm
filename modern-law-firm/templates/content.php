
<article <?php post_class(); ?>>
    <header> <?php
        $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), MLF_THUMBNAIL_IMG);
        $thumbnail = $post_thumb[0];
        $href = get_permalink();

        $imgClass = "alignright ml20";
        global $evenOddCount;
        if( $evenOddCount % 2 == 0 ) {
            $imgClass = "alignleft mr20";
        }
        if ($thumbnail != NULL) { ?>
            <div class="<?php echo $imgClass ?>">
                <a href="<?php echo $href; ?>" title="<?php the_title_attribute(); ?>">
                    <img class="mb0 featured-img" src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" width="<?php echo $post_thumb[1]; ?>" height="<?php echo $post_thumb[2]; ?>"/>
                </a>
                <?php fia_featured_img_attribution(); ?>
            </div><?php
        } ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php get_template_part( 'templates/entry-meta-short' ); ?>
    </header>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>
