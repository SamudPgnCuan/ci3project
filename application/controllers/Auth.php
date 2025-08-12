<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 */ 

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login_form');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password'); // langsung plaintext

        $user = $this->User_model->get_user($username, $password);

        if ($user && $user->password === $password) {
            $this->session->set_userdata([
                'username' => $user->username,
                'nama'     => $user->nama,
                'role'     => $user->role,
                'logged_in'=> TRUE
            ]);
            redirect('welcome'); 
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function profile()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('user/login_form');
        }

        $data['username'] = $this->session->userdata('username');
        $data['nama'] = $this->session->userdata('nama');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('profile', $data);
    }
}

    

    // public function profile()
    // {
    //     if (!$this->session->userdata('logged_in')) {
    //         redirect('user/login_form');
    //     }

    //     $data['username'] = $this->session->userdata('username');
    //     $data['nama'] = $this->session->userdata('nama');
    //     $data['role'] = $this->session->userdata('role');

    //     $this->load->view('profile', $data);
    // }
