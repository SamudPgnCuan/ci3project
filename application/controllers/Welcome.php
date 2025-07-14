<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		
		$data = [];

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('welcome_message', $data);
		$this->load->view('template/footer',);
	}
}
