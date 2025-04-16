<?php
class Codewpx_AIL_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }
    
    public function add_menu() {
        add_menu_page(
            'Auto Internal Linking',
            'Internal Links',
            'manage_options',
            'codewpx-auto-internal-linking',
            [$this, 'render_admin'],
            'dashicons-admin-links'
        );
    }
    
    public function render_admin() {
        include CODEWPX_AIL_PATH . 'admin/partials/codewpx-auto-internal-linking-admin-display.php';
    }
    
    public function enqueue_scripts($hook) {
        if ($hook === 'toplevel_page_codewpx-auto-internal-linking') {
            wp_enqueue_style('codewpx-admin-style', CODEWPX_AIL_URL . 'admin/css/codewpx-admin-style.css');
            wp_enqueue_script('codewpx-admin-script', CODEWPX_AIL_URL . 'admin/js/codewpx-admin-script.js', ['jquery']);
        }
    }
}