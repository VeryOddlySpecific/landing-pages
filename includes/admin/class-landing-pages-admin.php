<?php 

class Landing_Pages_Admin {
    // register post type
    // register settings

    public function register_cpt() {
        $cpt_data = json_decode( file_get_contents( VOS_LP_PATH . 'includes/assets/cpt.json' ), true );
        
        foreach ( $cpt_data as $cpt ) {
            register_post_type( $cpt['slug'], $cpt['args'] );
        }
    }
}