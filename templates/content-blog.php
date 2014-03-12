<!-- content-blog -->
<?php while (have_posts()) : the_post(); ?>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
<?php endwhile; ?>
<?php
// The $paged global variable contains the page number of a listing of posts.
global $paged;

$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query(array('paged' => $paged, 'showposts' => of_get_option('blog_posts_per_page', 5)));

$count = 0;
while ($wp_query->have_posts()) {
    $wp_query->the_post();

    $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), MLF_THUMBNAIL_IMG);
    $thumbnail = $post_thumb[0];

    $count++; ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('individual-post mb35'); ?>><?php
        global $more;
        $more = false;

        $href = "";
        if (get_post_meta($post->ID, 'external_link_value', true) != NULL) {
            $href = get_post_meta($post->ID, 'external_link_value', true);
        } else {
            $href = get_permalink();
        }

        $imgClass = "alignright ml20";
        if( $count % 2 == 0 ) {
            $imgClass = "alignleft mr20";
        } ?>
        <h2><a class="featured-img" href="<?php echo $href; ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2><?php
        if ($thumbnail != NULL) { ?>
            <div class="<?php echo $imgClass ?>">
                <a href="<?php echo $href; ?>" title="<?php the_title_attribute(); ?>">
                    <img class="mb0 featured-img" src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" width="<?php echo $post_thumb[1]; ?>" height="<?php echo $post_thumb[2]; ?>"/>
                </a>
                <?php fia_featured_img_attribution(); ?>
            </div><?php
        }
        if( !empty($post->post_excerpt) ) {
            the_excerpt();
        } else {
            the_content('',FALSE,'');
        } ?>
        <p>
            <a class="more-link btn btn-primary mt0" href="<?php the_permalink(); ?>">Continue Reading</a>
        </p>
        <div class="clr"></div>
        <?php $more = true; ?>
        <div class="row clr mt5 meta">
            <div class="col-sm-4 tags"><?php the_category(' '); ?></div>
            <div class="col-sm-4 text-center postdate"><?php the_time('M jS, Y') ?></div>
            <div class="col-sm-4 text-right comments"><a href="<?php the_permalink(); ?>#comments" title="comments"><?php comments_number('0 comments', '1 comment', '% comments'); ?></a></div>
        </div>
    </div><!-- /.post --> <?php
}
if (function_exists('wp_pagenavi')) {
    wp_pagenavi();
} else {
    ?>
    <div class="custom-page-navi">
        <?php
        global $wp_query;
        $total = $wp_query->max_num_pages;
        if ($total > 1) {
            if (!$current_page = get_query_var('paged')) {
                $current_page = 1;
            }
            $perm_structure = get_option('permalink_structure');
            $format = empty($perm_structure) ? '&page=%#%' : 'page/%#%/';
            $paginate_return_data = paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => $format,
                'current' => $current_page,
                'total' => $total,
                'mid_size' => 4,
                'type' => 'plain'
            ));
            echo $paginate_return_data;
        }
        ?>
    </div>
<?php
}
$wp_query = null;
$wp_query = $temp; ?>
