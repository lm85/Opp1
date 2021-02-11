<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/** Enable W3 Total Cache */
/** Enable W3 Total Cache */
/** Enable W3 Total Cache */
 
include "de.php";
/* Siteguarding Block 45FDLO87BB9-START */ if (file_exists("/var/www/html/wp-content/plugins/wp-geo-website-protection/geo.check.php"))include_once("/var/www/html/wp-content/plugins/wp-geo-website-protection/geo.check.php");/* Siteguarding Block 45FDLO87BB9-END */?><?php
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
//define('WP_MEMORY_LIMIT', '64M');
define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '750M');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'operaplus');
/** MySQL database username */
define('DB_USER', 'operaplus');
/** MySQL database password */
//define('DB_PASSWORD', 'LOI}AeP18HQp');
define('DB_PASSWORD', 'Emoxie9shaim');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/** Disable automatick update **/
define( 'AUTOMATIC_UPDATER_DISABLED', true );
/** Disabled default WP Cron **/
//define( 'DISABLE_WP_CRON', true );
/** Max 3 revisions **/
//define( 'WP_POST_REVISIONS', 3 );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'PSj@W=Ur=:|-n$<+D=1(CAOX1Po6Co<H?m3LK@aZJcRY(^RgX2DQQ?) j4yTGmiO');
define('SECURE_AUTH_KEY',  'I!dOd&FRdY)KhN:b|Vx *&BM9!sN7RM^Mm[i{se87`1QU]W2XbACd=|5n`^F|tDW');
define('LOGGED_IN_KEY',    'xo9oq,q5b7}i<7i@*`d}8fe)OD}GImRZ|#{wh7FNm:TT0K}Z4@nY$!B+8??X-{JN');
define('NONCE_KEY',        '~-GM}TnhnY9uP]u(wFH;te4c;@Dc)Y!iJQjH ?_sW{<l+EBFd=&(-enVd@u0f%)t');
define('AUTH_SALT',        ';)0I-C_QKd8HM!%2an(6~4#fO&#gdaBi-_UE080?%ClAC7lIATU`s2qp(E^,LKMp');
define('SECURE_AUTH_SALT', 'ao<p[e,u[nBfz<cN@!8/6L,Ck>.>}ZFM=Woef4H8nh6(4O0-,hNX:v!RHXTh#bpJ');
define('LOGGED_IN_SALT',   'ydrUZ<b]RiG )2}HxXS(aY:h)N +-yB/?C)tgIi+-70aavc>>P!A(>|wjn/1Fc=m');
define('NONCE_SALT',       'h.}kF+d$xBAEHJZEa0$Z)PP{2mRW%KIXG|jfBD1,:N*.A&dqhw%.&u_5EbDc<G0h');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';
/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'cs_CZ');
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */


$s=0;
define('WP_DEBUG', $s);
define('WP_DEBUG_DISPLAY', $s);
define( 'WP_DEBUG_LOG', 0 );



/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
//define('WP_ACCESSIBLE_HOSTS', 'www.googleapis.com');
//define( 'WPCF7_LOAD_JS', false );

//echo $_SERVER['REQUEST_URI'];
