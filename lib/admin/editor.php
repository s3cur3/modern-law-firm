<?php

function mlfEditorButtonHooks() {
    // Only add hooks when the current user has permissions AND is in Rich Text editor mode
    if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
        add_filter("mce_external_plugins", "mlfEditorRegisterTinyMCEJavascript");
        add_filter('mce_buttons', 'mlfEditorRegisterButtons');
    }
}
// init process for button control
add_action('init', 'mlfEditorButtonHooks');


function mlfEditorRegisterButtons( $buttons ) {
    array_push($buttons, '|', "columns", 'columns_adv', "coloredband", 'cta', 'practicearea', 'attorney', 'carousel');
    return $buttons;
}


// Load the TinyMCE plugin
function mlfEditorRegisterTinyMCEJavascript( $plugin_array ) {
    // Make sure the thickbox modal (dialog box) is available
    add_thickbox();

    $plugin_array['editor'] = get_template_directory_uri() . "/assets/js/admin/editor.js";
    return $plugin_array;
}






