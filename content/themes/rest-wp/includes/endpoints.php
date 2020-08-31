<?php

/**
 * Adds a front-page endpoint
 */
add_action('rest_api_init', 'ivn_front_page_route');

function ivn_front_page_route()
{
    register_rest_route('wp', '/v2/front-page', array(
        'methods' => 'GET',
        'callback' => 'ivn_get_front_page'
    ));
}

function ivn_get_front_page($object)
{
    $request = new WP_REST_Request('GET', '/wp/v2/posts');

    $frontpage_id = get_option('page_on_front');
    if ($frontpage_id) {
        $request = new WP_REST_Request('GET', '/wp/v2/pages/' . $frontpage_id);
    }

    $response = rest_do_request($request);
    if ($response->is_error()) {
        return new WP_Error('ivn_request_error', __('Request Error'), array('status' => 500));
    }

    $embed = $object->get_param('_embed') !== NULL;
    $data = rest_get_server()->response_to_data($response, $embed);

    return $data;
}

/**
 * Adds a main menu endpoint
 */
add_action('rest_api_init', 'ivn_main_menu_route');

function ivn_main_menu_route()
{
    register_rest_route('wp/v2/menus', 'main', array(
        'methods' => 'GET',
        'callback' => 'ivn_get_main_menu_items'
    ));
}

function ivn_get_main_menu_items(){
    if (($locations = get_nav_menu_locations()) && isset($locations[ 'main-menu' ])) {
        $menu = wp_get_nav_menu_object($locations['main-menu']);
        $menuItems = array();

        if (!empty($menu)) {
            $menu_items = wp_get_nav_menu_items($menu->term_id);

            if ($menu_items) {
                foreach ($menu_items as $key => $menu_item) {
                    if ($menu_item->menu_item_parent == 0) {
                        array_push(
                            $menuItems, array(
                                'title' => $menu_item->title,
                                'url' => str_replace( home_url(), '', $menu_item->url)
                            )
                        );
                    }
                }
            }
        }
    } else {
        return new WP_Error(
            'no_menus',
            'Could not find any menus',
            array(
                'status' => 404
            )
        );
    }

    return $menuItems;
}