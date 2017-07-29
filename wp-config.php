<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'dairmex');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'root');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'mO=UK!`W2Q~KzBY!.+?N[F-BJ]|r=RN4-HjvzZk,-zc{01c.{8VYf_$F6:ZXR|4N');
define('SECURE_AUTH_KEY', '1_{OMF]Xweb~;YK+V+A.`wH(9)uS+J,q=%[9To!E>^ dorI{Dhw-|[z2u8*p;&Xa');
define('LOGGED_IN_KEY', 'xz;5e1~JA;PN7egCp=Rq-gz2 ngnq vjj<%b_HB!VrM@ I:x.$Q$G.uHH+Jt$[XN');
define('NONCE_KEY', 's+.-m;]1|rGDS5N+/[s78/MoT6#D$<bQPf~zj}k!1:6^G3Z90._=A.yQ^V^h4&k^');
define('AUTH_SALT', '%T+6#C7_cW>J)>4mZLuv]HFP8t4JB(UaoOB+/>qRBmd{Qle<?dhqoD)*-q)fGhd<');
define('SECURE_AUTH_SALT', '*fB2b-/pq[g99lC7b8c+7%/Uxj5{~k9`4eoYjG73uF:NmErxQDs*6Gu+VZbHkaHS');
define('LOGGED_IN_SALT', 'GC@~ =g>o3*iv0jAI#xv(>|U-592$W:AT3jWD|N(k0_(JJeG3{m 7C[8[q;D#E~@');
define('NONCE_SALT', 'cr<)&o`Mkh2r]mT s~ 8JSj.67RU>sQpmiIFY@#1E|+B5E=2 uD~~P|+POq00p;m');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

