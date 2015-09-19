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
 * To see an example, check out: https://github.com/devinsays/options-framework-theme/blob/master/options.php
 */

function optionsframework_options() {
    $patternPath = get_template_directory_uri() . '/assets/img/patterns/';

	$options = array();


    /**************************************************************
                           Basics
     ***************************************************************/
    $options[] = array(
        'name' => __('Basics', MLF_TEXT_DOMAIN),
        'type' => 'heading');
    $options[] = array(
        'name' => __('', MLF_TEXT_DOMAIN),
        'desc' => __('<h3>Blog options</h3>', MLF_TEXT_DOMAIN),
        'type' => 'info');
    $options[] = array(
        'name' => __('Number of blog posts to show per page', MLF_TEXT_DOMAIN),
        'desc' => __('', MLF_TEXT_DOMAIN),
        'id' => 'blog_posts_per_page',
        'std' => '5',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('', MLF_TEXT_DOMAIN),
        'desc' => __('<h3>Footer options</h3>', MLF_TEXT_DOMAIN),
        'type' => 'info');
    $options[] = array(
        'name' => __('Number of columns in the footer', MLF_TEXT_DOMAIN),
        'desc' => __('Each widget in the footer "sidebar" will be treated as its own column.', MLF_TEXT_DOMAIN),
        'id' => 'footer_columns',
        'std' => '4',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('', MLF_TEXT_DOMAIN),
        'desc' => __('<h3>Google Analytics options</h3>', MLF_TEXT_DOMAIN),
        'type' => 'info');
    $options[] = array(
        'name' => __('Google Analytics ID', MLF_TEXT_DOMAIN),
        'desc' => __('Format: <code>UA-XXXXX-Y</code> (Note: Universal Analytics only, not Classic Analytics)', MLF_TEXT_DOMAIN),
        'id' => 'analytics_id',
        'std' => '',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('', MLF_TEXT_DOMAIN),
        'desc' => __('Note that Analytics tracking will <em>not</em> be active when you are logged in. (Open a different Web browser to test it.)', MLF_TEXT_DOMAIN),
        'type' => 'info');




    /**************************************************************
                Appearance (advanced)
     ***************************************************************/
    $options[] = array(
        'name' => __('Appearance (advanced)', MLF_TEXT_DOMAIN),
        'type' => 'heading');

    $options[] = array(
        'name' => __('', MLF_TEXT_DOMAIN),
        'desc' => __('<strong>NOTE</strong>: Basic appearance settings, including the colors used by the theme,' .
                     ' can be set using the Wordpress "<a href="./customize.php">Customize</a>" tool.<br />' .
                     '<a class="btn btn-primary mt10" href="./customize.php" style="text-decoration:none">Take me to the basic appearance options</a>', MLF_TEXT_DOMAIN),
        'type' => 'info');

    $options[] = array(
        'name' => __('Fix navigation bar to the top of the screen?', 'options_check'),
        'desc' => __('If checked, the navigation will follow the user down the page.', 'options_check'),
        'id' => 'navbar_fixed',
        'std' => '0',
        'type' => 'checkbox');

    $options[] = array(
        'name' => __('Firm Logo', MLF_TEXT_DOMAIN),
        'desc' => __('By default, we use the <a href="./options-general.php">site title</a> as the "logo." To use an image instead, set it here.<br /> Recommended size: 300x37.', MLF_TEXT_DOMAIN),
        'id' => 'firm_logo',
        'type' => 'upload');


    $options[] = array(
        'name' => __('SVG version of logo', MLF_TEXT_DOMAIN),
        'desc' => __('If you choose to use an SVG version of the logo, the bitmap (above) will be used as a fallback.', MLF_TEXT_DOMAIN),
        'id' => 'svg_logo',
        'type' => 'upload');
    $options[] = array(
        'name' => __('Width to display SVG', MLF_TEXT_DOMAIN),
        'desc' => __('(in pixels)&mdash;should be the same as the bitmap version\'s width', MLF_TEXT_DOMAIN),
        'id' => 'svg_logo_width',
        'std' => '',
        'class' => 'mini',
        'type' => 'text');
    $options[] = array(
        'name' => __('Height to display SVG', MLF_TEXT_DOMAIN),
        'desc' => __('(in pixels)&mdash;should be the same as the bitmap version\'s height', MLF_TEXT_DOMAIN),
        'id' => 'svg_logo_height',
        'std' => '',
        'class' => 'mini',
        'type' => 'text');

    $options[] = array(
        'name' => __('Full-screen background image', MLF_TEXT_DOMAIN),
        'desc' => __('To use a large image as the background to the pages (instead of a flat, solid color), upload an image here.<br /> Recommended size: 1600x1024 or larger.', MLF_TEXT_DOMAIN),
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
            'light_grey' => $patternPath . 'light_grey.png',
            'nice_snow' => $patternPath . 'nice_snow.png',
            'ricepaper_v3' => $patternPath . 'ricepaper_v3.png',
            'sandpaper' => $patternPath . 'sandpaper.png',
            'sos' => $patternPath . 'sos.png',
            'stardust_@2X' => $patternPath . 'stardust_@2X.png',
            'ticks_@2X' => $patternPath . 'ticks_@2X.png',
            'tweed_@2X' => $patternPath . 'tweed_@2X.png',
            'witewall_3_@2X' => $patternPath . 'witewall_3_@2X.png',
            'greyzz' => $patternPath . 'greyzz.png.png')
    );
    $options[] = array(
        'name' => __('Favicon for site', MLF_TEXT_DOMAIN),
        'desc' => __('A <a href="http://en.wikipedia.org/wiki/Favicon" target="_blank">favicon</a> is the little icon displayed in the page\'s tab. You can create one from a 16&times;16 image using the <a href="http://www.favicon.cc/" target="_blank">Favicon Generator</a>.', MLF_TEXT_DOMAIN),
        'id' => 'favicon',
        'type' => 'upload');
    $options[] = array(
        'name' => __('Apple Touch Icon', MLF_TEXT_DOMAIN),
        'desc' => __('When someone adds your site to their home screen on an Apple device (iPhone, iPad, etc.), the <a href="https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html" target="_blank">Apple Touch Icon</a> is the image that will be used. (Typically, a 152&times;152 PNG is recommended.)', MLF_TEXT_DOMAIN),
        'id' => 'touch_icon',
        'type' => 'upload');
    $options[] = array(
        'name' => __('Disable added effects on Apple Touch Icon?', 'options_check'),
        'desc' => __('Disable curved border, drop shadow, etc. for Apple touch icon', 'options_check'),
        'id' => 'touch_icon_precomposed',
        'std' => '0',
        'type' => 'checkbox');




    /**************************************************************
                Social media
     ***************************************************************/
    $options[] = array(
        'name' => __('Social Media Links', MLF_TEXT_DOMAIN),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Facebook URL', MLF_TEXT_DOMAIN),
        'desc' => __('URL for your firm\'s Facebook page. <br>(To hide the Facebook icon, leave this blank.)', MLF_TEXT_DOMAIN),
        'id' => 'fb',
        'std' => 'http://facebook.com/',
        'type' => 'text');

    $options[] = array(
        'name' => __('Twitter URL', MLF_TEXT_DOMAIN),
        'desc' => __('URL for your firm\'s Twitter page. <br />(To hide the Twitter icon, leave this blank.)', MLF_TEXT_DOMAIN),
        'id' => 'twitter',
        'std' => 'https://twitter.com/',
        'type' => 'text');

    $options[] = array(
        'name' => __('LinkedIn URL', MLF_TEXT_DOMAIN),
        'desc' => __('URL for your firm\'s LinkedIn page. <br />(To hide the LinkedIn icon, leave this blank.)', MLF_TEXT_DOMAIN),
        'id' => 'linkedin',
        'std' => 'http://www.linkedin.com/in/',
        'type' => 'text');

    $options[] = array(
        'name' => __('Google+ URL', MLF_TEXT_DOMAIN),
        'desc' => __('URL for your firm\'s Google+ page. <br />(To hide the Google+ icon, leave this blank.)', MLF_TEXT_DOMAIN),
        'id' => 'gplus',
        'std' => 'https://plus.google.com/',
        'type' => 'text');

    $options[] = array(
        'name' => __('Google+ link is to: ', MLF_TEXT_DOMAIN),
        'desc' => __('If you like, you can associate all pages of your site with an individual author or your organization. (<a href="http://www.searchenginejournal.com/claiming-google-authorship-and-publisher-markup-for-seo/61263/" target="_blank">More info</a>)', MLF_TEXT_DOMAIN),
        'id' => 'gplus_authorship',
        'std' => 'organization',
        'type' => 'select',
        'options' => $test_array = array(
                'author' => __('The site\'s primary "author"', MLF_TEXT_DOMAIN),
                'organization' => __('Your organization', MLF_TEXT_DOMAIN),
                'none' => __('None', MLF_TEXT_DOMAIN)
            ));

    $options[] = array(
        'name' => __('Display social media icons in full color?', MLF_TEXT_DOMAIN),
        'desc' => __('', MLF_TEXT_DOMAIN),
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
		'name' => __('Disclaimer', MLF_TEXT_DOMAIN),
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
		'name' => __('Disclaimer (for the bottom of each page)', MLF_TEXT_DOMAIN),
		'desc' => "If you'd like a disclaimer at the very, very bottom of each page, you can type it here.",
		'id' => 'disclaimer',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

    /**************************************************************
                Documentation
     ***************************************************************/
    $options[] = array(
        'name' => __('Documentation', MLF_TEXT_DOMAIN),
        'type' => 'heading' );

    $options[] = array(
        'name' => __('', MLF_TEXT_DOMAIN),
        'desc' => '<iframe src="' . get_template_directory_uri() . '/docs/modern-law-firm-documentation.html" style="width:100%;height:1080px;"></iframe>',
        'type' => 'info');

	return $options;
}