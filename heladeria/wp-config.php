<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'delpa23_wp85' );

/** MySQL database username */
define( 'DB_USER', 'delpa23_wp85' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'lbosodakhu220ebbi4eredoruntb5e3syrnwacclmceuc4obwzcrujmz8rblia3g' );
define( 'SECURE_AUTH_KEY',  'bafbhfhin7wdp5477159t4iba1klasiakeznima9ie2egpegv3lgebgc7h6akcwf' );
define( 'LOGGED_IN_KEY',    'nbbxdpf3ryseiawk1iznzzwzlmr7dew6nng83dsjqrbkxqw51znmvhsuph3chyvj' );
define( 'NONCE_KEY',        'q0dpxwgdgwgn16bk5ma6t1tqzvisgf0d8izjoh289of8qgxhwqeyqho86x3kn6lk' );
define( 'AUTH_SALT',        'dxjfl76js8bavhedqi5bubceokrsxe5ajm4svtrlsftjh8z9ht47jlx5qf1zup3s' );
define( 'SECURE_AUTH_SALT', 'xpngqmoqm6bwzdbk2zmlcpbcpf9u546rftty2ayydir1hnpyefjj2slfllssgprq' );
define( 'LOGGED_IN_SALT',   '9x7ywr3jvqbqv4d0udbohjjefjqaihce22cp00dvai7dp7j4vzea6jybuf3sbj5z' );
define( 'NONCE_SALT',       'ttp3kb58scayht31zncingmhz1jlhhy5gcuwfqzlgbxeac8w21qb8phcxfaoliaz' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpng_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
