<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 */

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('User_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    private function load_template($view, $data = [])
    {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function index()
    {
        $username = $this->session->userdata('username');
        $data['user'] = $this->User_model->get_by_username($username);
        $this->load_template('profile_view', $data);
    }

    public function edit()
    {
        $username = $this->session->userdata('username');
        $user = $this->User_model->get_by_username($username);

        if (!$user) {
            show_404();
        }

        $data['mode'] = 'edit';
        $data['user'] = $user;
        $this->load_template('profile_form', $data);
    }

    public function update()
    {
        $username = $this->session->userdata('username');

        // Validasi form
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim');

        if ($this->form_validation->run() === FALSE) {
            return $this->edit();
        }

        $data = [
            'nama' => $this->input->post('nama'),
        ];

        // Jika password diisi, update password
        if (!empty($this->input->post('password'))) {
            $data['password'] = $this->input->post('password'); // ⚠ plaintext, sebaiknya hash
        }

        $this->User_model->update($username, $data);

        // Update session nama kalau berubah
        $this->session->set_userdata('nama', $data['nama']);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('profile');
    }
}
