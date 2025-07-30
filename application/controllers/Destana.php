<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Destana_model $Destana_model
 * @property Destana_ancaman_model $Destana_ancaman_model
 * @property CI_Input $input
 * @property CI_DB_mysqli_driver $db
 */

class Destana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Destana_model');
        $this->load->model('Destana_ancaman_model');
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
            'id_kecamatan'    => $this->input->get('kecamatan'),
            'id_desa'         => $this->input->get('desa'),
            'tahun'           => $this->input->get('tahun'),
            'id_kelas'        => $this->input->get('id_kelas'),
            'id_sumber_dana'  => $this->input->get('id_sumber_dana'),
            'id_ancaman'      => $this->input->get('id_ancaman'),
        ];

        $data['mode'] = 'list';
        $data['destana'] = $this->Destana_model->get_all($filter);
        $data = array_merge($data, $this->Destana_model->get_master_lists());

        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-listfilter.js'];
        $this->load_template('destana_list', $data);
    }


    public function create()
    {
        $data['mode'] = 'create';
        $data['destana'] = null;
        
        $data = array_merge($data, $this->Destana_model->get_master_lists(true));
        $data['desa_list'] = [];
        
        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-form.js'];
        $this->load_template('destana_form', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $ancaman = $this->input->post('jenis_bencana');
        unset($data['jenis_bencana']);

        if ($this->Destana_model->insert($data)) {
            $id = $this->Destana_model->insert_id();

            if (!empty($ancaman)) {
                foreach ($ancaman as $id_ancaman) {
                    $this->Destana_ancaman_model->insert([
                        'id_destana' => $id,
                        'id_ancaman' => $id_ancaman
                    ]);
                }
            }
        }

        redirect('destana');
    }

    public function edit($id)
    {
        $data['mode'] = 'edit';
        $destana = $this->Destana_model->get_by_id($id);
        if (!$destana) {
            show_error("Data dengan ID $id tidak ditemukan", 404);
        }
        $destana->jenis_bencana = $this->Destana_ancaman_model->get_ancaman_ids_by_destana($id);
        $data['destana'] = $destana;
        $data = array_merge($data, $this->Destana_model->get_master_lists_for_edit($destana->id_desa));
        
        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-listfilter.js'];
        $this->load_template('destana_form', $data);
    }

    public function update()
    {
        $data = $this->input->post();
        $id = $data['id'];
        $ancaman = $this->input->post('jenis_bencana');
        unset($data['jenis_bencana']);

        $this->Destana_model->update(['id' => $id], $data);

        $this->db->where('id_destana', $id)->delete('destana_ancaman');
        if (!empty($ancaman)) {
            foreach ($ancaman as $id_ancaman) {
                $this->Destana_ancaman_model->insert([
                    'id_destana' => $id,
                    'id_ancaman' => $id_ancaman
                ]);
            }
        }

        redirect('destana');
    }

    public function delete($id)
    {
        $this->db->where('id_destana', $id)->delete('destana_ancaman');
        $this->Destana_model->delete(['id' => $id]);
        redirect('destana');
    }

    public function delete_bulk()
    {
        $selected = $this->input->post('ids');
        if (!empty($selected)) {
            foreach ($selected as $id) {
                $this->db->where('id_destana', $id)->delete('destana_ancaman');
                $this->Destana_model->delete(['id' => $id]);
            }
        }
        redirect('destana');
    }

    public function get_desa_by_kecamatan()
    {
        $id_kecamatan = $this->input->post('id_kecamatan');
        log_message('debug', 'ID KECAMATAN YANG DITERIMA: ' . $id_kecamatan);

        $kecamatan = $this->db->get_where('master_kecamatan', ['id_kecamatan' => $id_kecamatan])->row();
        if (!$kecamatan) {
            log_message('debug', 'TIDAK DITEMUKAN KECAMATAN');
            echo json_encode([]);
            return;
        }

        $kd_kec = $kecamatan->kode;

        $desa = $this->Destana_model->get_desa_yang_belum_dipakai($kd_kec);
        log_message('debug', 'JUMLAH DESA DITEMUKAN: ' . count($desa));

        echo json_encode($desa);
    }

}
