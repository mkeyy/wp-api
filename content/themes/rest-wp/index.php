<?php
/**
 * The main template file.
 *
 * @package Rest WP
 */

if(!is_user_logged_in()) {
    wp_redirect( wp_login_url() );
}
?>
