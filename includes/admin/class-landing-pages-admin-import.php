<?php

class Landing_Pages_Admin_Import {

    private $import_headers;

    public function import_data() {
        $post_data = $_POST;
        if ( !isset( $post_data['vos_lp_import_nonce'] ) || !wp_verify_nonce( $post_data['vos_lp_import_nonce'], 'vos_lp_import_action' ) ) {
            wp_die( 'Invalid request.' );
        }

        if ( isset( $post_data['submit'] ) && current_user_can( 'manage_options' && isset( $_FILES['vos_lp_import_file'] ) ) ) {
            $file = $_FILES['vos_lp_import_file'];

            if ( !$this->file_is_csv( $file ) ) {
                wp_die( 'Invalid file type.' );
            }

            $path   = $file['tmp_name'];
            $handle = fopen( $path, 'r' );
            $this->import_headers = fgetcsv( $handle );
            $f_row  = true;
            while ( ( $row = fgetcsv( $handle ) ) !== false ) {
                if ( $f_row ) {
                    $f_row = false;
                    continue;
                }
                $this->insert_data( $row );
            }
        }
    }

    public function file_is_csv( $file ) {
        $file_info = wp_check_filetype( $file['name'] );
        return $file_info['ext'] === 'csv' ? true : false;
    }

    public function insert_data( $row ) {
        // post_title should be city name, state abbreviation
        $city_idx   = array_search( 'city', $this->import_headers );
        $state_idx  = array_search( 'state', $this->import_headers );
        $post_title = $row[ $city_idx ] . ', ' . $row[ $state_idx ];
        $post_type  = 'voslp-cities';
        $post_tags  = '';
        $post_meta  = array();
        foreach ( $row as $key => $value ) {
            if ( $key !== $city_idx && $key !== $state_idx ) {
                $post_tags .= $value . ', ';
                $post_meta[ $this->import_headers[ $key ] ] = $value;
            }
        }

        $post_args = array(
            'post_title'   => $post_title,
            'post_type'    => $post_type,
            'post_status'  => 'publish',
            'post_content' => '',
            'tags_input'   => $post_tags,
            'meta_input'   => $post_meta
        );

        wp_insert_post( $post_args );
    }

    public function setup() {
        add_action( 'admin_post_vos_lp_import', array( $this, 'import_data' ) );
    }
}