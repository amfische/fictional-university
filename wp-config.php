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
define( 'DB_NAME', 'fictional_university' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '_1@4O<,M3~v&OIS3nsp19{FN.g[W:9i8+u ?o1<hEMpmm1]p+>#%x,eJ[rb5:&1P' );
define( 'SECURE_AUTH_KEY',  'x|L,``W9t/S&DID0VTyv}6=5_0$2o.Kx(1hz~Em6{e|`H}qq&hc[isv<Hv#UbCZY' );
define( 'LOGGED_IN_KEY',    'savDf pKvg>])H3NfTXDYi:D%MM?:pJS`OZ_9bI7qj;&E(^c$8Hs(n+s>G[sQhz ' );
define( 'NONCE_KEY',        'l0HQ?Nio&xCapk[x1n/y&-*U}&~lCuvIXDRnefX#7;=0=jWF_V;*T<P*ahlWcfoW' );
define( 'AUTH_SALT',        'dx+D!NX L?5~Zxkh(_mx53`H}SZ@Eid;W]sWOp;.|vWK}7K&z@puV&6<`,o.KcsW' );
define( 'SECURE_AUTH_SALT', 'Q`BN%t`c?sKAtM:mSSw20f0C9iv)Y]p<fI8Opa/uKh7TRrmd|s^.lQ3ES?Yds>y{' );
define( 'LOGGED_IN_SALT',   'SH/nWzOsZHK!YeYknLi0@1?pvcU^S<ez2X+~=X8#>qqNzoChKYT/8sG_bdvG) `n' );
define( 'NONCE_SALT',       'HH}Zm_,OxA`Ac}`t/L=$ vUh9|(?Xi#NH#XnHX=wJ[5i: _bd,GEklvznN-va:VR' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
