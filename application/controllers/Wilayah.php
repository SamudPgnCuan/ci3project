<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Destana_model $Destana_model
 * @property CI_Input $input
 * @property CI_DB_mysqli_driver $db
 */

class Wilayah extends CI_Controller
{
    public function get_desa_by_kecamatan($id_kecamatan)
    {
        header('Content-Type: application/json');

        $only_unused = $this->input->get('unused') === 'true'; // default $only_unused false dan semua data ditampilkan

        // Ambil kode kecamatan
        $kecamatan = $this->db->get_where('master_kecamatan', ['id_kecamatan' => $id_kecamatan])->row();
        if (!$kecamatan) {
            echo json_encode([]);
            return;
        }

        $kd_kec = $kecamatan->kode;

        if ($only_unused) {
            $id_desa_aktif = $this->input->get('aktif');
            $this->load->model('Destana_model');
            $desa = $this->Destana_model->get_desa_unused($kd_kec, $id_desa_aktif);
        } else {
            // Ambil semua desa berdasarkan kode kecamatan
            $this->db->where('kd_kec', $kd_kec);
            $desa = $this->db->get('master_desa')->result();
        }

        echo json_encode($desa);
    }
}
