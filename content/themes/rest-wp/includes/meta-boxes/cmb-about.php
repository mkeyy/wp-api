<?php
add_action('cmb2_init', 'ivn_about_metaboxes');

function ivn_about_metaboxes()
{
    $prefix = 'ivn_about_';

    /** @var $settings */
    $settings = new_cmb2_box(array(
        'id' => $prefix . 'settings',
        'title' => __('Ustawienia', 'cmb2'),
        'object_types' => array('page'),
        'show_on' => array(
            'key' => 'template',
            'value' => 'templates/about.php'
        ),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
        'show_in_rest' => WP_REST_Server::READABLE,
        'closed' => false
    ));
    $settings->add_field(array(
        'name' => __('Podtytuł', 'cmb2'),
        'id' => $prefix . 'subtitle',
        'type' => 'text'
    ));
    $settings->add_field(array(
        'name' => __('Zawartość', 'cmb2'),
        'id' => $prefix . 'content',
        'type' => 'wysiwyg'
    ));
}
