<?php
/**
 * Plugin Name: Ivision Base
 * Description: Ivision Base Theme features plugin
 * Author: Ivision
 * Author URI: ivision.pl
 * Version: 0.1
 */

/**
 * If this file is called directly, abort.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include main class
 */
require_once('includes/Base.php');

/**
 * Initialize
 */
add_action('plugins_loaded', array('Ivn\Base', 'getInstance'));