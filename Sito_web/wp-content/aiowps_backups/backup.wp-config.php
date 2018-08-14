<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via
 * web, è anche possibile copiare questo file in «wp-config.php» e
 * riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Prefisso Tabella
 * * Chiavi Segrete
 * * ABSPATH
 *
 * È possibile trovare ultetriori informazioni visitando la pagina del Codex:
 *
 * @link https://codex.wordpress.org/it:Modificare_wp-config.php
 *
 * È possibile ottenere le impostazioni per MySQL dal proprio fornitore di hosting.
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define('DB_NAME', 'essenzial');

/** Nome utente del database MySQL */
define('DB_USER', 'essenzial');

/** Password del database MySQL */
define('DB_PASSWORD', 'essAIMial');



/** Hostname MySQL  */
define('DB_HOST', 'localhost');

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define('DB_CHARSET', 'utf8');

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'c#{%*&;CJ{~>HJdN)Zl]9MkM?ImaOg+gobry7<5X>lE$92S4g^JNbW`+7=2E%%)V');
define('SECURE_AUTH_KEY',  'F*5>#ZcSMW`T$H=}GW09%Q)m$xJpNPN%eR}o ]NK!s>fT6;n@udkG*(>jJ}dWZp%');
define('LOGGED_IN_KEY',    'T3ihrZo+KFZ*e%^`A3rP-SvN>]6|.S%L)i=#.A^uxkPJMY9twC/jwhP.^A$,.@.:');
define('NONCE_KEY',        'yb?FXU VXHvWwg_djfc*#@rsKV4rKTy]7qtUMHrGO}IQsMnNq{Md=t)-7@H!BW3;');
define('AUTH_SALT',        '@O7EQBwV]WqxJx8zdZQ>z hd/qj|ivwJ#{FFqxGQ.C|U4/E6Uyg4f?nEj<Z<W6Eb');
define('SECURE_AUTH_SALT', '2^/ 6lxYx~Kh:{Sli}zsY?6!N1LULC;c5NZ,y^$,Y[7lek}3|%KC7>ZlS+qQ6=xh');
define('LOGGED_IN_SALT',   '^E=T$q`s%qZCZ{^V3kT?B&*!Nnkm*$vJCF3`%t=K%>[H;eeBmSNZ@ZzZQrM-fF%J');
define('NONCE_SALT',       '`@`Ejk)3%0V#X(V&)y0$F@`93-l[Uw3lku[;@+]B}]*40ep:I;?HJt*YU&s=4kB=');

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix  = 'wp_';
/*
 * Handle multi domain into single instance of wordpress installation
 */
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 */
define('WP_DEBUG', false);
define( 'AUTOMATIC_UPDATER_DISABLED', true );

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');
