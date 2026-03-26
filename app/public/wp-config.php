<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'uvnCmSBg=M!e0j((x ~y:/92c7x!L9?%K2vI@*&C^HiAFA`ZV! WKl6VHs$~P&>r' );
define( 'SECURE_AUTH_KEY',   'N1(q/;hTuha9Oz(&=W84U.L.I],9Zw[^|fNHI}};Y_)HyLhle!HX.37DnmNs=zE>' );
define( 'LOGGED_IN_KEY',     'SmW)Glxgpv=u 7Luo 2wtTKMePLP $b->=p*S@$8f50c,/zizY3ym>m /Pe^}RRf' );
define( 'NONCE_KEY',         '&Lzx^4j5o5v=mc=ZfF%b|@&5!f@VegAF17[)DETHVHJp94+h$y=b+C[@H*]<j>wL' );
define( 'AUTH_SALT',         'qK(3$<.zx|*`YP/Cb*I_[8%e;~fg8GX]g/K^?&Ra1J/)Bt=/Vd|fTL9X&Y*#L<9C' );
define( 'SECURE_AUTH_SALT',  'xL-_>61{X+Ko.?b:D!~#zib[C,G`MDe!ynJ:$$cr%v]MG.NQONM)hTD[IaYCX^qz' );
define( 'LOGGED_IN_SALT',    'fkHx2G}>0qV.{^<sQu/Bo19AG-9##`?yFbnIE,<jVC u<cZ5I3qQik*.*GBk8T4K' );
define( 'NONCE_SALT',        '&OE:M?b%ESbE`91{G4~&y;7Dfs{@/f~}zf{|h[zr!OO2`DW>>`4L-|XyT%rM?CxE' );
define( 'WP_CACHE_KEY_SALT', '<}u;m/Ai;}`v#`/Q)sEXF$quA8_mU0CL^7TXeztES)1L:%g{hgrhS2#jV.[%eLV@' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
