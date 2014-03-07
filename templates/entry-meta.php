<?php /*
<time class="published alignright" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
<p class="byline author vcard"><?php echo __('By', TEXT_DOMAIN); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></p>
 */ ?>
<div class="post-data">
    <div class="author">
        <div class="author-img"><?php echo get_avatar( get_the_author_meta('ID'), 96, '', 'By ' . get_the_author() ) ?></div>
        <p>This post was written by <a itemprop="author" href="<?php the_author_meta('user_url'); ?>"><?php the_author(); ?></a>.</p>
        <p><?php the_author_meta('description'); ?></p>
    </div>
    <p>Published <time itemprop="datePublished" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>.</p>

    <?php
    $categoryHTML = get_the_category_list( ' &bull; '  );
    $tagHTML = get_the_tag_list('<span class="the-tags">Tagged: ',' &bull; ','</span>');
    if( $categoryHTML || $tagHTML ) {
        $taxonomyHTML = "<p>";
        $taxonomyHTML .= ($categoryHTML ? "Posted in: $categoryHTML" : '' );
        if( $categoryHTML && $tagHTML ) {
            $taxonomyHTML .= "</p><p>";
        }
        $taxonomyHTML .= ($tagHTML ? $tagHTML : '' );
        $taxonomyHTML .= "</p>";
        echo $taxonomyHTML;
    }
    ?>
</div>