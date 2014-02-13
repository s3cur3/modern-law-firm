<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = "The Modern Law Firm";//wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
    $patternPath = get_template_directory_uri() . '/assets/img/patterns/';

	$options = array();


    /**************************************************************
                           Basics
     ***************************************************************/
    $options[] = array(
        'name' => __('Basics', 'options_framework_theme'),
        'type' => 'heading');
    $options[] = array(
        'name' => __('', 'options_framework_theme'),
        'desc' => __('<h3>Blog options</h3>', 'options_framework_theme'),
        'type' => 'info');
    $options[] = array(
        'name' => __('Number of blog posts to show per page', 'options_framework_theme'),
        'desc' => __('', 'options_framework_theme'),
        'id' => 'blog_posts_per_page',
        'std' => '5',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('', 'options_framework_theme'),
        'desc' => __('<h3>Footer options</h3>', 'options_framework_theme'),
        'type' => 'info');
    $options[] = array(
        'name' => __('Number of columns in the footer', 'options_framework_theme'),
        'desc' => __('Each widget in the footer "sidebar" will be treated as its own column.', 'options_framework_theme'),
        'id' => 'footer_columns',
        'std' => '4',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('', 'options_framework_theme'),
        'desc' => __('<h3>Google Analytics options</h3>', 'options_framework_theme'),
        'type' => 'info');
    $options[] = array(
        'name' => __('Google Analytics ID', 'options_framework_theme'),
        'desc' => __('Format: <code>UA-XXXXX-Y</code> (Note: Universal Analytics only, not Classic Analytics)', 'options_framework_theme'),
        'id' => 'analytics_id',
        'std' => '',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('', 'options_framework_theme'),
        'desc' => __('Note that Analytics tracking will <em>not</em> be active when you are logged in. (Open a different Web browser to test it.)', 'options_framework_theme'),
        'type' => 'info');




    /**************************************************************
                Appearance (advanced)
     ***************************************************************/
    $options[] = array(
        'name' => __('Appearance (advanced)', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('', 'options_framework_theme'),
        'desc' => __('<strong>NOTE</strong>: Basic appearance settings, including the colors used by the theme,' .
                     ' can be set using the Wordpress "<a href="./customize.php">Customize</a>" tool.<br />' .
                     '<a class="btn btn-primary mt10" href="./customize.php" style="text-decoration:none">Take me to the basic appearance options</a>', 'options_framework_theme'),
        'type' => 'info');

    $options[] = array(
        'name' => __('Firm Logo', 'options_framework_theme'),
        'desc' => __('By default, we use the <a href="./options-general.php">site title</a> as the "logo." To use an image instead, set it here.<br /> Recommended size: 300x37.', 'options_framework_theme'),
        'id' => 'firm_logo',
        'type' => 'upload');

    $options[] = array(
        'name' => __('Full-screen background image', 'options_framework_theme'),
        'desc' => __('To use a large image as the background to the pages (instead of a flat, solid color), upload an image here.<br /> Recommended size: 1600x1024 or larger.', 'options_framework_theme'),
        'id' => 'full_screen_image_bg',
        'type' => 'upload');

    $options[] = array(
        'name' => "Background pattern",
        'desc' => "To use a subtle pattern (from subtlepatterns.com) as the background to the pages (instead of a flat, solid color or an image), select a pattern here.",
        'id' => "pattern_bg",
        'std' => "2c-l-fixed",
        'type' => "images",
        'options' => array(
            'brushed_@2X' => $patternPath . 'brushed_@2X.png',
            'grey_wash_wall' => $patternPath . 'grey_wash_wall.jpg',
            'light_grey' => $patternPath . 'light_grey',
            'nice_snow' => $patternPath . 'nice_snow',
            'ricepaper_v3' => $patternPath . 'ricepaper_v3',
            'sandpaper' => $patternPath . 'sandpaper',
            'sos' => $patternPath . 'sos',
            'stardust_@2X' => $patternPath . 'stardust_@2X',
            'ticks_@2X' => $patternPath . 'ticks_@2X',
            'tweed_@2X' => $patternPath . 'tweed_@2X',
            'witewall_3_@2X' => $patternPath . 'witewall_3_@2X',
            'greyzz' => $patternPath . 'greyzz.png')
    );




    /**************************************************************
                Social media
     ***************************************************************/
    $options[] = array(
        'name' => __('Social Media Links', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Facebook URL', 'options_framework_theme'),
        'desc' => __('URL for your firm\'s Facebook page. <br>(To hide the Facebook icon, leave this blank.)', 'options_framework_theme'),
        'id' => 'fb',
        'std' => 'http://facebook.com/',
        'type' => 'text');

    $options[] = array(
        'name' => __('Twitter URL', 'options_framework_theme'),
        'desc' => __('URL for your firm\'s Twitter page. <br />(To hide the Twitter icon, leave this blank.)', 'options_framework_theme'),
        'id' => 'twitter',
        'std' => 'https://twitter.com/',
        'type' => 'text');

    $options[] = array(
        'name' => __('LinkedIn URL', 'options_framework_theme'),
        'desc' => __('URL for your firm\'s LinkedIn page. <br />(To hide the LinkedIn icon, leave this blank.)', 'options_framework_theme'),
        'id' => 'linkedin',
        'std' => 'http://www.linkedin.com/in/',
        'type' => 'text');

    $options[] = array(
        'name' => __('Google+ URL', 'options_framework_theme'),
        'desc' => __('URL for your firm\'s Google+ page. <br />(To hide the Google+ icon, leave this blank.)', 'options_framework_theme'),
        'id' => 'gplus',
        'std' => 'https://plus.google.com/',
        'type' => 'text');

    $options[] = array(
        'name' => __('Google+ link is to: ', 'options_framework_theme'),
        'desc' => __('If you like, you can associate all pages of your site with an individual author or your organization. (<a href="http://www.searchenginejournal.com/claiming-google-authorship-and-publisher-markup-for-seo/61263/" target="_blank">More info</a>)', 'options_framework_theme'),
        'id' => 'gplus_authorship',
        'std' => 'organization',
        'type' => 'select',
        'options' => $test_array = array(
                'author' => __('The site\'s primary "author"', 'options_framework_theme'),
                'organization' => __('Your organization', 'options_framework_theme'),
                'none' => __('None', 'options_framework_theme')
            ));

    $options[] = array(
        'name' => __('Display social media icons in full color?', 'options_framework_theme'),
        'desc' => __('', 'options_framework_theme'),
        'id' => 'social_icons_color',
        'std' => false,
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => array(
            true => 'Yes, full color',
            false => 'No, monochrome'
        ));




    /**************************************************************
                Disclaimer
     ***************************************************************/
	$options[] = array(
		'name' => __('Disclaimer', 'options_framework_theme'),
		'type' => 'heading' );

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Disclaimer (for the bottom of each page)', 'options_framework_theme'),
		'desc' => "If you'd like a disclaimer at the very, very bottom of each page, you can type it here.",
		'id' => 'disclaimer',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

    /**************************************************************
                Documentation
     ***************************************************************/
    $options[] = array(
        'name' => __('Documentation', 'options_framework_theme'),
        'type' => 'heading' );

    $options[] = array(
        'name' => __('', 'options_framework_theme'),
        'desc' => '<iframe src="' . get_template_directory_uri() . '/docs/modern-law-firm-documentation.html" style="width:100%;height:1080px;"></iframe>',
        'type' => 'info');

	return $options;
}