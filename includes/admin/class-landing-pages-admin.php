<?php 

class Landing_Pages_Admin {

    private $cpt_data;

    public function __construct() {
        $this->load_dependencies();
        $this->set_cpt_data();
    }

    private function load_dependencies() {
        require_once VOS_LP_PATH . 'includes/admin/class-landing-pages-admin-display.php';
    }

    private function set_cpt_data() {
        $this->cpt_data = json_decode( file_get_contents( VOS_LP_PATH . 'includes/assets/cpt.json' ), true );
    }

    public function register_cpt() {
        foreach ( $this->cpt_data as $cpt ) {
            register_post_type( $cpt['slug'], $cpt['args'] );
            if ( isset( $cpt['taxonomies'] ) ) {
                foreach ( $cpt['taxonomies'] as $taxonomy ) {
                    register_taxonomy( $taxonomy['slug'], $cpt['slug'], $taxonomy['args'] );
                }
            }
        }
    }

    public function run() {
        add_action( 'init', array( $this, 'register_cpt' ) );
    }
}