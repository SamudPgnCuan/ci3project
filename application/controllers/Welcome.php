<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        check_login(); 
    }

	public function index()
	{
		
		$data = [];

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('welcome_message', $data);
		$this->load->view('template/footer',);

		// $data['scripts'] = ['bencana-charts.js'];
	}
}
