<?php 

class Codewpx_Link_Processor {  
    public function find_and_replace_links( $content ) {  
        $keywords = get_option( 'codewpx_ail_keywords', array() );  
        if ( empty( $keywords ) ) return $content;  

        foreach ( $keywords as $keyword => $url ) {  
            $content = preg_replace(  
                '/\b(' . preg_quote( $keyword, '/' ) . ')\b/i',  
                '<a href="' . esc_url( $url ) . '" class="codewpx-internal-link">$1</a>',  
                $content  
            );  
        }  
        return $content;  
    }  
}  

