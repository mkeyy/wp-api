<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

/** The name of the database for WordPress */
define('DB_NAME', 'database_name_here');

/** MySQL database username */
define('DB_USER', 'username_here');

/** MySQL database password */
define('DB_PASSWORD', 'password_here');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define( 'WPLANG', '' );

/**
 * WordPress Content Dir
 * Since Version 2.6, you can move the wp-content directory, which holds your themes, plugins, and
 * uploads, outside of the WordPress application directory.
 *
 * Set WP_CONTENT_DIR to the full local path of this directory (no trailing slash), e.g.
 * Set WP_CONTENT_URL to the full URI of this directory (no trailing slash), e.g.
 */
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/content' );

/**
 * AutoSave Interval
 *
 * When editing a post, WordPress uses Ajax to auto-save revisions to the post as you edit.
 * You may want to increase this setting for longer delays in between auto-saves, or decrease
 * the setting to make sure you never lose changes. The default is 60 seconds.
 */
define( 'AUTOSAVE_INTERVAL', 86400 );

/**
 * Post Revisions
 *
 * WordPress, by default, will save copies of each edit made to a post or page, allowing the
 * possibility of reverting to a previous version of that post or page. The saving of revisions
 * can be disabled, or a maximum number of revisions per post or page can be specified.
 */
define( 'WP_POST_REVISIONS', false );

/**
 * Debug
 *
 * The WP_DEBUG option, added in WordPress Version 2.3.1, controls the display of some errors and warnings.
 * If this setting is absent from wp-config.php, then the value is assumed to be false.
 *
 * Additionally, if you are planning on modifying some of WordPress' built-in JavaScript, you should enable SCRIPT_DEBUG
 */
define( 'WP_DEBUG', true );
define( 'SCRIPT_DEBUG', false );

/**
 * Error Logging
 *
 * Because wp-config.php is loaded for every page view not loaded from a cache file, it is an excellent
 * location to set php ini settings that control your php installation. This is useful if you don't
 * have access to a php.ini file, or if you just want to change some settings on the fly.
 */
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );

/**
 * Admin Script Concatenation
 *
 * To result in a faster administration area, all Javascript files are concatenated into one URL. If
 * Javascript is failing to work in your administration area, you can try disabling this feature.
 */
define( 'CONCATENATE_SCRIPTS', true );

/**
 * Memory Allocation
 *
 * Also released with Version 2.5, the WP_MEMORY_LIMIT option allows you to specify the maximum amount
 * of memory that can be consumed by PHP. This setting may be necessary in the event you receive a message
 * such as "Allowed memory size of xxxxxx bytes exhausted".
 *
 * This setting increases PHP Memory only for WordPress, not other applications. By default, WordPress
 * will attempt to increase memory allocated to PHP to 32MB (code is at beginning of wp-settings.php), so
 * the setting in wp-config.php should reflect something higher than 32MB.
 */
define( 'WP_MEMORY_LIMIT', '64M' );
define( 'WP_MAX_MEMORY_LIMIT', '64M' );

/**
 * Save queries for analysis
 *
 * The SAVEQUERIES definition saves the database queries to a array and that array can be displayed to help
 * analyze those queries. The information saves each query, what function called it, and how long that query took to execute.
 *
 * @see http://codex.wordpress.org/Editing_wp-config.php#Save_queries_for_analysis
 */
define( 'SAVEQUERIES', true );

/**
 * Empty Trash
 *
 * Added with Version 2.9, this constant controls the number of days before WordPress permanently deletes
 * posts, pages, attachments, and comments, from the trash bin. The default is 30 days.
 */
define( 'EMPTY_TRASH_DAYS', 30 );

/**
 * Automatic background core updates settings.
 */
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/**
 * Default theme name.
 */
define( 'WP_DEFAULT_THEME', 'ivn-base-theme' );

/**
 * Define Google Maps API Key
 */
define( 'GOOGLE_API_KEY', '' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
}

/** Include Composer autoloader */
require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );