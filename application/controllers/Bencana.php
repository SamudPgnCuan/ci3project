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

    public function index($page = 0)
    {
        $filter = [
            'id_kecamatan'   => $this->input->get('kecamatan'),
            'id_desa'        => $this->input->get('desa'),
            'id_ancaman'     => $this->input->get('id_ancaman'),
            'tanggal_mulai'  => $this->input->get('tanggal_mulai'),
            'tanggal_selesai'=> $this->input->get('tanggal_selesai'),
        ];

        $allData = $this->Bencana_model->get_all($filter);

        // Pagination manual di view aja
        $limit = 40;
        $total = count($allData);
        $offset = $page * $limit;
        $pagedData = array_slice($allData, $offset, $limit);

        $data['bencana'] = $pagedData;
        $data['total'] = $total;
        $data['page'] = $page;
        $data['limit'] = $limit;

        $data = array_merge($data, $this->Bencana_model->get_master_lists());

        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-listfilter.js'];
        $this->load_template('bencana_list', $data);
    }



    public function create()
    {
        $data['mode'] = 'create';
        $data['bencana'] = null;

        $data = array_merge($data, $this->Bencana_model->get_master_lists());
        $data['desa_list'] = [];

        $data['load_select2'] = true;
        $data['scripts'] = ['dropdown-bencana-form.js'];
        $this->load_template('bencana_form', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        // normalisasi date sesuai format MySQL
        if (!empty($data['tanggal_bencana'])) {
            $data['tanggal_bencana'] = str_replace('T', ' ', $data['tanggal_bencana']);
            if (strlen($data['tanggal_bencana']) === 16) { // kurang detik
                $data['tanggal_bencana'] .= ':00';
            }
        }

        // yang gaada di form
        $data['created_by'] = $this->session->userdata('id'); 
        $data['created_at'] = date('Y-m-d H:i:s');            

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
        $data = array_merge($data, $this->Bencana_model->get_master_lists());

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

    public function get_by_destana($id_destana)
    {
        header('Content-Type: application/json');
        $result = $this->Bencana_model->get_by_destana($id_destana);
        echo json_encode($result);
    }

    public function stats_yearly()
    {
        header('Content-Type: application/json');

        $start = (int) $this->input->get('start_year') ?: 2010;
        $end   = (int) $this->input->get('end_year') ?: (int) date('Y');

        // ambil filter sama seperti index
        $filter = [
            'id_kecamatan'   => $this->input->get('kecamatan'),
            'id_desa'        => $this->input->get('desa'),
            'id_ancaman'     => $this->input->get('id_ancaman'),
            'tanggal_mulai'  => $this->input->get('tanggal_mulai'),
            'tanggal_selesai'=> $this->input->get('tanggal_selesai'),
        ];

        $rows = $this->Bencana_model->get_yearly_stats($start, $end, $filter);

        // normalisasi label tahun dari start..end
        $map = [];
        foreach ($rows as $r) $map[(int)$r['tahun']] = (int)$r['total'];

        $labels = [];
        $data = [];
        for ($y = $start; $y <= $end; $y++) {
            $labels[] = (string)$y;
            $data[] = isset($map[$y]) ? $map[$y] : 0;
        }

        echo json_encode(['labels' => $labels, 'data' => $data, 'start' => $start, 'end' => $end]);
    }

    public function stats_monthly()
        {
            header('Content-Type: application/json');

            $year = (int) $this->input->get('year') ?: (int) date('Y');

            $filter = [
                'id_kecamatan'   => $this->input->get('kecamatan'),
                'id_desa'        => $this->input->get('desa'),
                'id_ancaman'     => $this->input->get('id_ancaman'),
                // note: monthly stats use YEAR filter, tanggal range optional but ignored here
                'tanggal_mulai'  => $this->input->get('tanggal_mulai'),
                'tanggal_selesai'=> $this->input->get('tanggal_selesai'),
            ];

            $rows = $this->Bencana_model->get_monthly_stats($year, $filter);

            $map = [];
            foreach ($rows as $r) $map[(int)$r['bulan']] = (int)$r['total'];

            $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $data = [];
            for ($m = 1; $m <= 12; $m++) {
                $data[] = isset($map[$m]) ? $map[$m] : 0;
            }

            echo json_encode(['labels' => $labels, 'data' => $data, 'year' => $year]);
        }

}
