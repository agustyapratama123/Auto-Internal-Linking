<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://agustyapratama.com
 * @since      1.0.0
 *
 * @package    Auto_Internal_Linking
 * @subpackage Auto_Internal_Linking/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Auto_Internal_Linking
 * @subpackage Auto_Internal_Linking/admin
 * @author     agustya pratama <agustyapratama76@gmail.com>
 */
class Auto_Internal_Linking_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function add_admin_menu() {  
        add_menu_page(  
            'Auto Internal Linking',  
            'Internal Linking',  
            'manage_options',  
            'codewpx-auto-internal-linking',  
            array( $this, 'display_admin_page' ),  
            'dashicons-admin-links'  
        );  
    }  

    public function display_admin_page() {  
        include_once CODEWPX_AIL_PLUGIN_DIR . 'admin/partials/codewpx-auto-internal-linking-admin-display.php';  
    }  

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Auto_Internal_Linking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Auto_Internal_Linking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/auto-internal-linking-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Auto_Internal_Linking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Auto_Internal_Linking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/auto-internal-linking-admin.js', array( 'jquery' ), $this->version, false );

	}

}
