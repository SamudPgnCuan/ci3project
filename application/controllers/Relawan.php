<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Relawan_model $Relawan_model
 * @property CI_Input $input
 */
class Relawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Relawan_model');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form']);
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
        $data['relawan'] = $this->Relawan_model->get_all(); 
        $this->load_template('relawan_list', $data);
    }

    public function create()
    {
        $data['relawan'] = null;
        $data['mode'] = 'create';
        $this->load_template('relawan_form', $data);
    }

    public function store() {
        $data = $this->input->post();
        $this->Relawan_model->insert($data);
        redirect('relawan');
    }

    public function edit($nik)
    {
        $data['relawan'] = $this->Relawan_model->get_by_nik($nik);
        $data['mode'] = 'edit';
        $this->load_template('relawan_form', $data);
    }

    public function update($nik) {
        $data = $this->input->post();
        $this->Relawan_model->update($nik, $data);
        redirect('relawan');
    }

    public function delete($nik)
    {
        $this->Relawan_model->delete($nik);
        redirect('relawan');
    }

    public function delete_bulk()
    {
        $niks = $this->input->post('niks');
        if ($niks) {
            foreach ($niks as $nik) {
                $this->Relawan_model->delete($nik);
            }
        }
        redirect('relawan');
    }

}
