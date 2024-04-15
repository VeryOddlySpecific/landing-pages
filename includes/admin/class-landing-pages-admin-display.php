<?php 

class LandingPages_Admin_Display {

    public function add_admin_page() {
        add_menu_page(
            'Landing Pages',
            'Landing Pages',
            'manage_options',
            'landing-pages',
            '',
            'dashicons-admin-page',
            6
        );
    }
}