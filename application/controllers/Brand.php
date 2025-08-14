<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Brand extends CI_Controller {

    private function load_template($view, $data = [])
    {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function index()
    {
        $data = [];

        $this->load_template('brand_page', $data);
    }
}
