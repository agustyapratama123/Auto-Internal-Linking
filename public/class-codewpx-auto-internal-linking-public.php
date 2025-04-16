<?php
class Codewpx_AIL_Public {
    public function __construct() {
        add_filter('the_content', [$this, 'process_content']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }
    
    public function process_content($content) {
        if (is_singular()) {
            $processor = new Codewpx_AIL_Link_Processor();
            return $processor->process($content);
        }
        return $content;
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style('codewpx-public-style', CODEWPX_AIL_URL . 'public/css/codewpx-public-style.css');
        wp_enqueue_script('codewpx-public-script', CODEWPX_AIL_URL . 'public/js/codewpx-public-script.js', ['jquery'], false, true);
    }
}