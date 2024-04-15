<?php 

class Landing_Pages {

    private $admin;
    private $public;

    public function __construct() {
        $this->load_dependencies();
        $this->set_controls();
    }

    private function load_dependencies() {
        require_once VOS_LP_PATH . 'includes/admin/class-landing-pages-admin.php';
        require_once VOS_LP_PATH . 'includes/public/class-landing-pages-public.php';
    }

    private function set_controls() {
        $this->admin = new Landing_Pages_Admin();
        $this->public = new Landing_Pages_Public();
    }

    public function run() {
        $this->admin->run();
        $this->public->run();
    }
}