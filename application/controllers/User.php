<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model //cuma biar gak merah di vscode hehe gak kebaca dinamisitas ci
 * @property CI_Input $input
 */

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
    $data['users'] = $this->User_model->get_all();

    // Memuat template AdminLTE
    $this->load->view('template/header');
    $this->load->view('user_list', $data);
    $this->load->view('template/footer');
}


    public function create() {
        $this->load->view('user_form', ['mode' => 'add']);
    }

    public function store() {
        $data = $this->input->post();
        $this->User_model->insert($data);
        redirect('user');
    }

    public function edit($username) {
        $user = $this->User_model->get_by_username($username);
        $this->load->view('user_form', ['user' => $user, 'mode' => 'edit']);
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
