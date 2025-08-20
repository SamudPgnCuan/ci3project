<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Bencana_model $Bencana_model
 */

class Bencana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('Bencana_model');
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
        $filter = [
            'id_kecamatan'   => $this->input->get('kecamatan'),
            'id_desa'        => $this->input->get('desa'),
            'id_ancaman'     => $this->input->get('id_ancaman'),
            'tanggal_mulai'  => $this->input->get('tanggal_mulai'),
            'tanggal_selesai'=> $this->input->get('tanggal_selesai'),
        ];

        $data['mode'] = 'list';
        $data['bencana'] = $this->Bencana_model->get_all($filter);
        $data = array_merge($data, $this->Bencana_model->get_master_lists());

        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-listfilter.js'];
        $this->load_template('bencana_list', $data);
    }

    public function create()
    {
        $data['mode'] = 'create';
        $data['bencana'] = null;

        $data = array_merge($data, $this->Bencana_model->get_master_lists(true));
        $data['desa_list'] = [];

        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-bencana-form.js'];
        $this->load_template('bencana_form', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $this->Bencana_model->insert($data);

        redirect('bencana');
    }

    public function edit($id)
    {
        $data['mode'] = 'edit';
        $bencana = $this->Bencana_model->get_by_id($id);
        if (!$bencana) {
            show_error("Data dengan ID $id tidak ditemukan", 404);
        }

        $data['bencana'] = $bencana;
        $data = array_merge($data, $this->Bencana_model->get_master_lists(true, $bencana->id_desa));

        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-form.js'];
        $this->load_template('bencana_form', $data);
    }

    public function update()
    {
        $data = $this->input->post();
        $id = $data['id'];
        unset($data['id']);

        $this->Bencana_model->update(['id' => $id], $data);
        redirect('bencana');
    }

    public function delete($id)
    {
        $this->Bencana_model->delete(['id' => $id]);
        redirect('bencana');
    }
}
