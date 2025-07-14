<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Destana_model $Destana_model //cuma biar gak merah di vscode hehe gak kebaca ci3 nya
 * @property CI_Input $input
 */

class Destana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Destana_model');
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
        $data['destana'] = $this->Destana_model->get_all();
        $this->load_template('destana_list', $data);
    }


    public function create()
    {
        $data['destana'] = null;
        $this->load_template('destana_form', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $this->Destana_model->insert($data);
        redirect('destana');
    }


    public function edit($no)
    {
        $destana = $this->Destana_model->get_by_id(['no' => $no]);
        $data['destana'] = $destana;
        $this->load_template('destana_form', $data);
    }

    public function update()
    {
        $no = $this->input->post('no');
        $data = [
            'kecamatan' => $this->input->post('kecamatan'),
            'desa' => $this->input->post('desa')
        ];
        $this->Destana_model->update(['no' => $no], $data);
        redirect('destana');
    }

    public function delete($no)
    {
        $this->Destana_model->delete(['no' => $no]);
        redirect('destana');
    }

    public function delete_bulk()
    {
        $selected = $this->input->post('desa_ids');
        if ($selected) {
            foreach ($selected as $no) {
                $this->Destana_model->delete(['no' => $no]);
            }
        }
        redirect('destana');
    }

}
