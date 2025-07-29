<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Relawan_model $Relawan_model
 * @property CI_Input $input
 * @property CI_DB_mysqli_driver $db
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
        $id_kecamatan = $this->input->get('kecamatan');
        $id_desa = $this->input->get('desa');

        $data['mode']    = 'list';
        $data['relawan'] = $this->Relawan_model->get_all($id_kecamatan, $id_desa);
        $data = array_merge($data, $this->Relawan_model->get_master_lists());

        $data['load_select2'] = true;
        $data['custom_script'] = 'relawan.js';
        
        $this->load_template('relawan_list', $data);
    }


    public function create()
    {
        $data['mode'] = 'create';
        $data['relawan'] = null;
        $data = array_merge($data, $this->Relawan_model->get_master_lists());
        $this->load_template('relawan_form', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $this->Relawan_model->insert($data);
        redirect('relawan');
    }

    public function edit($id)
    {
        $data['mode'] = 'edit';
        $relawan = $this->Relawan_model->get_by_id($id);
        if (!$relawan) {
            show_error("Data dengan ID $id tidak ditemukan", 404);
        }
        $data['relawan'] = $relawan;
        $data = array_merge($data, $this->Relawan_model->get_master_lists());
        $this->load_template('relawan_form', $data);
    }

    public function update($id)
    {
        $data = $this->input->post();
        $this->Relawan_model->update($id, $data);
        redirect('relawan');
    }

    public function delete($id)
    {
        $this->Relawan_model->delete($id);
        redirect('relawan');
    }

    public function delete_bulk()
    {
        $ids = $this->input->post('ids');
        if ($ids) {
            foreach ($ids as $id) {
                $this->Relawan_model->delete($id);
            }
        }
        redirect('relawan');
    }

    public function get_desa_by_kecamatan()
    {
        header('Content-Type: application/json');

        $id_kecamatan = $this->input->get('kecamatan'); 

        // Debug: log input
        log_message('debug', 'ID Kecamatan: ' . $id_kecamatan);
        
        // Ambil kode dari master_kecamatan berdasarkan ID
        $kecamatan = $this->db->get_where('master_kecamatan', ['id_kecamatan' => $id_kecamatan])->row();

        if (!$kecamatan) {
            log_message('debug', 'Kecamatan tidak ditemukan untuk ID: ' . $id_kecamatan);
            echo json_encode([]); // Jika tidak ketemu, kirim data kosong
            return;
        }

        log_message('debug', 'Kode Kecamatan: ' . $kecamatan->kode);

        // Ambil semua desa dengan kd_kec yang sesuai dengan kode dari kecamatan
        $desa = $this->db
                    ->select('id_desa, nama_desa')
                    ->where('kd_kec', $kecamatan->kode)
                    ->get('master_desa')
                    ->result();

        log_message('debug', 'Jumlah desa ditemukan: ' . count($desa));

        echo json_encode($desa);
    }


}
