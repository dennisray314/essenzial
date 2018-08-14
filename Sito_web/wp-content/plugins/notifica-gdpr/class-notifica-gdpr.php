<?php 


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


final class Notifica_GDPR{
	
	const meta_key_acceptance = "notifica_gdpr_accettazione";
	
	protected static $_instance = null;
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __clone() {
		wp_die ();
	}
	
	public function __wakeup() {
		wp_die ();
	}
	
	public function __construct() {
		
		$this->init_hooks();
		
		do_action( 'notifica_gdpr_loaded' );
	}
	
	public function add_css(){
		wp_enqueue_style( 'notifica-gdpr', NOTIFICAGDRP_URL . 'gdpr.css', false );
	}
	
	public function handle_notification($user_login, $user){
		$this->check_request();
		
		$gdpr_meta = get_user_meta( get_current_user_id() , self::meta_key_acceptance , true);
		
		if (empty($gdpr_meta) || "no" == $gdpr_meta) {
			$this->load_alert();	
		}
	
	}
	
	public function get_logo(){
		
		if ( function_exists('x_get_option')) {
			return x_get_option( 'x_logo' );
		} 
		else return get_header_image();
		
		
	}
	
	public function load_alert(){
		
		include_once  NOTIFICAGDRP_PATH .'/gdpr-alert-template.php';
	}
	
	private function check_request(){
		
		
		if (isset($_POST['action']) && $_POST['action'] == 'notifica_gdpr_form') {
			$acceptance_choice = $_POST['notifica_gdpr_accept'];
			update_user_meta( get_current_user_id(), self::meta_key_acceptance, $acceptance_choice);	
		}
	}
	
	private function init_hooks() {
	
		add_action('wp_enqueue_scripts',  array( $this, 'add_css') );
		if (isset($_GET['gdpr'])) add_action('wp_head', array( $this, 'handle_notification'), 10, 2);
		
	}
	
}