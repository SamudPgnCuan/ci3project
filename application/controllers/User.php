<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property CI_Input $input
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_login();
        check_admin();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form']);
    }

    private function load_template($view, $data = []) {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function index() {
        $data['users'] = $this->User_model->get_all();
        $this->load_template('user_list', $data);
    }

    public function create() {
        $data['user'] = null;
        $data['mode'] = 'create';
        $this->load_template('user_form', $data);
    }

    public function store() {
        $data = $this->input->post();
        $this->User_model->insert($data);
        redirect('user');
    }

    public function edit($username) {
        $data['mode'] = 'edit';
        $user = $this->User_model->get_by_username($username);
        if (!$user) {
            show_404(); 
        }
        $data['user'] = $user;
        $this->load_template('user_form', $data);
    }


    public function update($username) {
        $data = $this->input->post();
        $this->User_model->update($username, $data);
        redirect('user');
    }

    public function delete($username) {
        $this->User_model->delete($username);
        redirect('user');
    }

}
