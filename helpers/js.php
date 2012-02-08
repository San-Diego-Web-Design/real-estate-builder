<?php 

PL_Js_Helper::init();

class PL_Js_Helper {

	public function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin' ));
	}	

	public function admin ($hook) {
		$pages = array('placester_page_placester_properties', 'placester_page_placester_property_add');

		if (!in_array($hook, $pages)) { return; }

		// hack to force jquery to load properly. Needs to be removed once there's time to 
		// sort out who is using what.
    	wp_register_script( 'jquery2', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
	    wp_enqueue_script( 'jquery2' );
		
		if ($hook == 'placester_page_placester_properties') {
			self::register_enqueue_if_not('chosen', trailingslashit(PL_JS_LIB_URL) .  'chosen/chosen.jquery.min.js', array( 'jquery'));			
			self::register_enqueue_if_not('datatables', trailingslashit(PL_JS_LIB_URL) .  'datatables/jquery.dataTables.js', array( 'jquery'));			
			self::register_enqueue_if_not('my-listings', trailingslashit(PL_JS_URL) .  'admin/my-listings.js', array( 'jquery'));			
		}

		if ($hook == 'placester_page_placester_property_add') {
			self::register_enqueue_if_not('add-listing', trailingslashit(PL_JS_URL) .  'admin/add-listing.js', array( 'jquery'));			
		}
		
	}

	private function register_enqueue_if_not($name, $path, $dependencies = array(), $version = null, $in_footer = false) {
		if (!wp_script_is($name, 'registered')) {
			wp_register_script($name, $path, $dependencies, $version, $in_footer);		
		}

		if ( !wp_script_is($name, 'queue') ) {
			wp_enqueue_script($name);		
		}	
	}

//end class
}