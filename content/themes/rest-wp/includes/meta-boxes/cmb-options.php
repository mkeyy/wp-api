<?php
/**
 * This snippet has been updated to reflect the official supporting of options pages by CMB2
 * in version 2.2.5.
 *
 * If you are using the old version of the options-page registration,
 * it is recommended you swtich to this method.
 */
add_action('cmb2_init', 'ivn_register_options_metaboxes');
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function ivn_register_options_metaboxes()
{
    /**
     * Registers options page menu item and form.
     */
    $options = new_cmb2_box(array(
        'id' => 'ivn_options_metabox',
        'title' => esc_html__('Options', 'ivn-theme'),
        'object_types' => array('options-page'),
        'option_key' => 'ivn_options',
        'show_in_rest' => WP_REST_Server::READABLE,
        'icon_url' => 'dashicons-screenoptions',
    ));

    /**
     * Options fields ids only need
     * to be unique within this box.
     * Prefix is not needed.
     */

    /** Logo */
    $options->add_field(array(
        'name' => esc_html__('Logo', 'ivn-theme'),
        'id' => 'logo',
        'type' => 'file',
        'query_args' => array(
            'type' => 'image/png',
        )
    ));
}
