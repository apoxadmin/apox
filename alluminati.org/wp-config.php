<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //

/** Get database info from centralized file */
require( ABSPATH . 'include/connection.inc.php' );

/** The name of the database for WordPress */
//define('DB_NAME', '');

/** MySQL database username */
//define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', DB_PASS);

/** MySQL hostname */
//define('DB_HOST', '');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'U4|jg_~9Ji:d(fr39CPlM.6~^&PZY@b1&X$*9iyLWLAdr=F$D-JIDR+yWwutEGjC');
define('SECURE_AUTH_KEY',  '2+3#t|yHQc-H ?_,^+HMnx,7tcqdD QO5,GIN )?qQ+I5Lo_C,xVl]I]Hy?v Zxf');
define('LOGGED_IN_KEY',    '<w{-u+>de5z)@G-2z8]2 =~n18U0H/IqJET[cDG{+5-E$9;srV OlBb.Bj(ZD%a7');
define('NONCE_KEY',        '9%T$d]{2&ZpIre`JH oaa-AQbC0[aMSN:c0y9?|Q_A`i|>]o=rb(z~LeWCE2P@Vt');
define('AUTH_SALT',        'bpt~k=sYT_33-PvD%+x?y[0tt0vY&Mci9gIQeQ;Zt.* EW|;lVJJx>$h_/Ko2gAK');
define('SECURE_AUTH_SALT', '|Gx!AuaSd#&[+4>=#I[v?/NU]+v)qm YVgy+<FZ(|ro3|srk?DE+w@jsDnK9&_(>');
define('LOGGED_IN_SALT',   ':F0tHlh~!JiS7d+m8y)e%BCT4K-[/`En0M`YN9KOJQ}aC>XTGc=h0g_x)H+!^QWx');
define('NONCE_SALT',       ':x98T~i?Ej+]AMn!0mc-B{BR&[|?xHXZ?}bk7220y:s3!}PA{p7YHN0gj+Q!NK_ ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp1_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('WP_MEMORY_LIMIT','96M');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
