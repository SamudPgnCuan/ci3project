<?php

/**
 * @property Destana_model $Destana_model //cuma biar gak merah di vscode hehe gak kebaca dinamisitas ci
 * @property CI_Input $input
 */

class Destana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Destana_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['destana'] = $this->Destana_model->get_all();
        $this->load->view('destana_list', $data);
    }

    public function create()
    {
        $this->load->view('destana_form');
    }

    public function store()
    {
        $data = [
            'kecamatan' => $this->input->post('kecamatan'),
            'desa' => $this->input->post('desa')
        ];
        $this->Destana_model->insert($data);
        redirect('destana');
    }
}
