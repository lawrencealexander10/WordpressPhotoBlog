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
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'o5+u;#|~+^(`jdpWq^e,&C#]t/2|DG++E{hvXe(#&7d$y3AVM.bJsQ}rUxn)D6PW');
define('SECURE_AUTH_KEY',  '8=y^6++M!088;Do-PLRKpfg[axHapSeGZD~SJENh|08O_@Q6R_hbz/s6:5W;I2@)');
define('LOGGED_IN_KEY',    '8AdO?d,r$0cZB+I}z8Y29p&~:_Z|^D|c=D!eLPJV0KNYM2S~q{1O=yu-S0s3@_K~');
define('NONCE_KEY',        'jf0`%tE[]~e2]hgYJA{:#S!P]96Q+y$G)oqi^271z$c9UF*8H-U& IETpkWnN|+f');
define('AUTH_SALT',        'xzdXN7=j~z5g6{87Asds(4c7S[-Njb<!6& 1-]gJttHTB:4S,m}.lA+=E4N[+(|2');
define('SECURE_AUTH_SALT', ';mrLmp8;R`[3vd rZLlEvk=ah:OOCEj}v}4Yt||z-d%.(Z83B?P)P_yzdLUu)2TU');
define('LOGGED_IN_SALT',   ',4ol,Y|[h8~Fu]}:}|&Isw[h* |G!&cV5}~L:N4^LjQl<S|<;IfkG()7HNxy-C2[');
define('NONCE_SALT',       'Vh1rr^+7il(glzxPLVM[.( .w?uk~?p;GdEs^h~QPVys[+QjKm.&6,vfi]$,G7:`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
