<?php
add_action('cmb2_init', 'ivn_homepage_metaboxes');

function ivn_homepage_metaboxes()
{
    $prefix = 'ivn_homepage_';

    /** @var $settings */
    $settings = new_cmb2_box(array(
        'id' => $prefix . 'settings',
        'title' => __('Ustawienia', 'cmb2'),
        'object_types' => array('page'),
        'show_on' => array(
            'key' => 'id',
            'value' => get_option('page_on_front')
        ),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
        'show_in_rest' => WP_REST_Server::READABLE,
        'closed' => false
    ));
    $settings->add_field(array(
        'name' => __('Tytuł', 'cmb2'),
        'id' => $prefix . 'title',
        'type' => 'text'
    ));
    $settings->add_field(array(
        'name' => __('Podtytuł', 'cmb2'),
        'id' => $prefix . 'subtitle',
        'type' => 'text'
    ));
    $settings->add_field(array(
        'name' => __('Wideo Plakat', 'cmb2'),
        'id' => $prefix . 'video_poster',
        'type' => 'file',
        'query_args' => array(
            'type' => 'image/jpg',
        )
    ));
    $settings->add_field(array(
        'name' => __('Wideo', 'cmb2'),
        'id' => $prefix . 'video',
        'type' => 'file',
        'query_args' => array(
            'type' => 'video/mp4',
        )
    ));
}
