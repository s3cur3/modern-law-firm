<?php
/*================================================================
 * NOTE: This file will override the standard layout for ALL of
 * the theme's pages. (All templates inherit from base.php.)
 *
 * This file doesn't do anything really interesting... it just
 * removes the Bootstrap functionality, as a way of demonstrating
 * how you might modify the base template.
 *================================================================*/

get_template_part( 'templates/head' );

?>
<body <?php body_class(); ?>>

<?php
do_action( 'get_header' );

get_template_part( 'templates/header' );
?>
<div class="wrap" role="document">
        <main class="main" role="main">
            The following is printed from the child theme's <code>base.php</code> file:
            <?php childThemeFunction(); ?>
            <?php include roots_template_path(); ?>
        </main>
        <!-- /.main -->
        <?php if( roots_display_sidebar() ) : ?>
            <aside class="sidebar" role="complementary">
                <?php include roots_sidebar_path(); ?>
            </aside><!-- /.sidebar -->
        <?php endif; ?>
    </div>
    <!-- /.content -->
</div>
<!-- /.wrap -->

<?php get_template_part( 'templates/footer' ); ?>

</body>
</html>
