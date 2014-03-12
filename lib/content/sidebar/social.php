<?php

/**
 * @param $url string The URL for the user's social media page
 * @param $brandStr string The "brand" name used by FontAwesome: "facebook", "twitter", "google-plus", or "linkedin"
 *                          See all icons here: http://fontawesome.io/icons/
 */
function getSocialLink( $url, $brandStr ) {
    return "<a href=\"$url\" target=\"_blank\" class=\"social\"><i class=\"fa fa-2x fa-{$brandStr}-square\"></i></a>";
}

/**
 * Prints a list of social media links. By default, it uses the theme-wide (Options Framework-specified)
 * URLs for Facebook, Twitter, Google+, and LinkedIn.
 *
 * You can override these URLs using the parameter.
 * @param string[] $profilesOverride The URLs to use. This should be an associative array with (optional)
 *                                   entries for 'facebook', 'twitter', 'google-plus', and 'linkedin'
 * @param string $additionalListClass An additional class to apply to the ul tag
 */
function printSocialLinks( $profilesOverride=array(), $additionalListClass ) {
    echo getSocialLinks($profilesOverride, $additionalListClass);
}

/**
 * Returns a list of social media links. By default, it uses the theme-wide (Options Framework-specified)
 * URLs for Facebook, Twitter, Google+, and LinkedIn.
 *
 * You can override these URLs using the parameter.
 * @param string[] $profilesOverride The URLs to use. This should be an associative array with (optional)
 *                                   entries for 'facebook', 'twitter', 'google-plus', and 'linkedin'
 * @param string $additionalListClass An additional class to apply to the ul tag
 * @return string An unordered list of social icons
 */
function getSocialLinks( $profilesOverride=array(), $additionalListClass ) {
    $profiles = array(
        "facebook" => of_get_option( 'fb' ),
        "twitter" => of_get_option('twitter'),
        "google-plus" => of_get_option('gplus'),
        "linkedin" => of_get_option('linkedin')
    );

    if( count($profilesOverride) > 0 ) {
        $profiles = $profilesOverride;
    }

    $class = "social-list";
    if( of_get_option('social_icons_color') ) {
        $class .= " colored";
    }

    $out = "<ul class=\"$class {$additionalListClass}\">";
    foreach( $profiles as $key => $val ) {
        if( $val ) {
            $out .= '<li class="social-profile">';
            $out .= getSocialLink($val, $key);
            $out .= '</li>';
        }
    }
    $out .= "</ul>";
    return $out;
}


/**
 * @param int $postID The ID of the attorney "post" whose links we should look up
 * @return string[] The override profile links to use with printSocialLinks()
 */
function getAttorneySocialURLs($postID=null) {
    $arr = array(
        'facebook' => mlfGetNormalizedMeta('facebook', '', $postID),
        'twitter' => mlfGetNormalizedMeta('twitter', '', $postID),
        'google-plus' => mlfGetNormalizedMeta('google-plus', '', $postID),
        'linkedin' => mlfGetNormalizedMeta('linkedin', '', $postID),
    );

    return $arr;
}


/**
 * @param array $urlArray The array spit out by getAttorneySocialURLs()
 * @return boolean True if there are no "real" social URLs; false otherwise
 */
function socialURLsAreEmpty( $urlArray ) {
    $arrayNonEmpty = false;
    foreach( $urlArray as $key => $val ) {
        if( strlen($val) > 0 ) {
            $arrayNonEmpty = true;
            break;
        }
    }
    return !$arrayNonEmpty;
}


/**
 * Prints the <link rel="publisher"> or <link rel="author"> tags, as appropriate
 */
function printGoogleAuthorshipLink() {
    // If $authorship is set to 'organization', we'll print the rel="publisher"
    // markup; similarly, if set to 'author', we'll add rel="author" to the link.
    $authorship = of_get_option("gplus_authorship");
    $gplus = of_get_option('gplus');
    if( $authorship == 'author' ) {
        echo "\n<link href=\"$gplus\" rel=\"author\" />\n";
    } else if( $authorship == 'organization' ) {
        echo "\n<link href=\"$gplus\" rel=\"publisher\" />\n";
    }
}
add_action( 'wp_head', 'printGoogleAuthorshipLink' );


class SocialMediaWidget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'SocialMediaWidget', // Base ID
            __('Social Media Icons', 'text_domain'), // Name
            array('description' => __('Displays links to your social media profiles', 'text_domain'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        printSocialLinks();
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Connect with Us', 'text_domain');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        <p>We'll put a link to each of your social media icons here.</p>
        <p>(To configure which icons are shown, and which pages they link to, visit <a href="<?php echo get_site_url(); ?>/wp-admin/themes.php?page=options-framework" target="_blank">Appearance > Theme Options</a>, and click the Social Media tab.)</p>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

// register Foo_Widget widget
function register_social_widget() {
    register_widget( 'SocialMediaWidget' );
}
add_action( 'widgets_init', 'register_social_widget' );

?>
