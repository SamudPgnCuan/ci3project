<?php

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
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    public function index()
{
    $data['destana'] = $this->Destana_model->get_all(); 
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('destana_list', $data);
    $this->load->view('template/footer');
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


    public function edit($no)
    {
        $destana = $this->Destana_model->get_by_id(['no' => $no]);
        if (!$destana) {
            show_404();
        }

        $data['destana'] = $destana;
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('destana_form', $data); // gunakan form yang sama untuk create & edit
        $this->load->view('template/footer');
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
