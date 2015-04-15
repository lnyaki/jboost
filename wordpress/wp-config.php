<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'weBNeGYea7EGFcWr');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '`tW<8oEWu|[B.`]xmIVx0P&Ssf4AjVr11aL%-LDGpB5~BkN{B;CzdB(<_g[a%XhJ');
define('SECURE_AUTH_KEY',  'WEy#G@DMD6Be{$U8H@L+[}CN=%!| rQ!/LO/b+&n=BXc1LF4t)aFw_B^BR:6}yXd');
define('LOGGED_IN_KEY',    'XI+)r{,>$a(E7K1CV.#X+-@T0f/(4r^M:n6)Us6%$3^?<i= .si%m$?u ;<Dky*q');
define('NONCE_KEY',        '$=>b|_:C3=8>q18O|=BEhbn|?O6+t|P!MF9=%u~W~AM+1U}*^S<HU/Yqr l8[6U}');
define('AUTH_SALT',        'w3^P,,/$*.wA5TIB _m<~3j!r;gp5^$#-Gj}66V!TuR`YVpnL@SaiY;l)BFx@1K%');
define('SECURE_AUTH_SALT', 'gB3<M0~|;%X|gZ[U/oU$K.&_z!TV#z QG@emAc]JnouFg,vL?NXRoz_EP_U+@xdW');
define('LOGGED_IN_SALT',   '{Anbo2k%xbxG1Qz.(L+:ZSa+NnWxD3nv9,-YR-?jf5(P@@:D:#+H=5GNZn#8yz?x');
define('NONCE_SALT',       'FCB-b+W>|sQI6WP#BeE<./S+?#NxSwv)U`[Ac/I_2XG=6eSPom!:Cb?+}+/xT>12');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_01';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
