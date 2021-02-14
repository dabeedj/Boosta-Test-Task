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
define( 'DB_NAME', 'secretbu_boosta' );

/** MySQL database username */
define( 'DB_USER', 'secretbu_boosta' );

/** MySQL database password */
define( 'DB_PASSWORD', '*Yvi4%7u2F' );

/** MySQL hostname */
define( 'DB_HOST', 'secretbu.mysql.tools' );

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
define( 'AUTH_KEY',         'M?,)MIi4OZ`FXN~-ECY~Nw(OSC=7in&g-eIdTtC$]Ecm7|Kr`Myn-!ZTxb4][Ob|' );
define( 'SECURE_AUTH_KEY',  '1r$?WBM6aZwH%9UB.oI?jVIY:@`Xqzx`WoqIjx1}Qr<PDcS9-:-B*{%3/m%=XVh)' );
define( 'LOGGED_IN_KEY',    'GW^8{3IY<]yI(!O~0(VUUn=TXQB66Ask=@5|<$qL;u`O+Y`GKe{-2Y/Q<:Eg1&@3' );
define( 'NONCE_KEY',        '|z ~2NDlt?zRb-.zF3t`i0>BB1U.F3+cd}]Xg>6$%2]Z72}@Q#yih_;_p[;ji4U,' );
define( 'AUTH_SALT',        'YqV}S;GM5YmE.%utq&%HzSLw]U:XwPo~Z|zj}KDy:)War:8P&3G,mKpK<4BsmQUq' );
define( 'SECURE_AUTH_SALT', 'P-IC3Qc&?s&89i{nZ-=d(qs,N0{(+W.k7!]?-^Ff%A>s^wAG_t<,Ya%JA`Zb3U2A' );
define( 'LOGGED_IN_SALT',   'GU/P@qx@;tVW`T9c*D?N.,M9!|&n.0}Te z/=l.y<j@=L68 ts(VH}R[QWndN.LN' );
define( 'NONCE_SALT',       'jQO+PNjdc?_5E{&Hb |wa7;:{/O1.Bjux.&M^-CPY@4moBe8Xo*1+j_0tg_R88s3' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

// For the sake of product generation
define('ALLOW_UNFILTERED_UPLOADS', true);