<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Bencana_model $bencana
 */

class Bencana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_login();

        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('Bencana_model', 'bencana');
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    // List + Filter
    public function index()
    {
        $filters = [
            'id_kecamatan'   => $this->input->get('id_kecamatan'),
            'id_desa'        => $this->input->get('id_desa'),
            'id_ancaman'     => $this->input->get('id_ancaman'),
            'tanggal_mulai'  => $this->input->get('tanggal_mulai'),
            'tanggal_selesai'=> $this->input->get('tanggal_selesai'),
        ];
        $data['rows'] = $this->bencana->list($filters);

        // Dropdown filter
        $data['kecamatan'] = $this->bencana->get_kecamatan_all();
        $data['ancaman']   = $this->bencana->get_ancaman_all();

        // Untuk menjaga nilai filter di form
        $data['filters'] = $filters;

        $this->load->view('bencana/bencana_list', $data);
    }

    public function create()
    {
        // Dropdown kecamatan & ancaman
        $data['kecamatan'] = $this->bencana->get_kecamatan_all();
        $data['ancaman']   = $this->bencana->get_ancaman_all();
        $this->load->view('bencana/bencana_form', $data);
    }

    public function store()
    {
        // Validasi form
        $this->form_validation->set_rules('tanggal_bencana', 'Tanggal Kejadian', 'required');
        $this->form_validation->set_rules('id_destana', 'Desa (Destana)', 'required|integer');
        $this->form_validation->set_rules('jumlah_korban', 'Jumlah Korban', 'required|integer');

        if ($this->form_validation->run() === FALSE) {
            return $this->create();
        }

        $payload = [
            'id_destana'       => (int)$this->input->post('id_destana'),
            'id_ancaman'       => $this->input->post('id_ancaman') ? (int)$this->input->post('id_ancaman') : NULL,
            'tanggal_bencana'  => $this->input->post('tanggal_bencana'), // format: Y-m-d H:i:s dari input datetime-local
            'jumlah_korban'    => (int)$this->input->post('jumlah_korban'),
            'detail_kerusakan' => $this->input->post('detail_kerusakan'),
            'created_by'       => (int)$this->session->userdata('id'), // sesuaikan key session id user
            // created_at otomatis oleh DB
        ];

        $this->bencana->insert($payload);
        $this->session->set_flashdata('success', 'Laporan bencana berhasil ditambahkan.');
        redirect('bencana');
    }

    public function edit($id)
    {
        $row = $this->bencana->find($id);
        if (!$row) {
            show_404();
        }

        $data['row']       = $row;
        $data['kecamatan'] = $this->bencana->get_kecamatan_all();
        $data['ancaman']   = $this->bencana->get_ancaman_all();

        // preload: daftar destana di kecamatan bersangkutan
        $data['destana_opsi'] = $this->bencana->get_destana_by_kecamatan($row->id_kecamatan);

        $this->load->view('bencana/bencana_form', $data);
    }

    public function update($id)
    {
        $row = $this->bencana->find($id);
        if (!$row) {
            show_404();
        }

        $this->form_validation->set_rules('tanggal_bencana', 'Tanggal Kejadian', 'required');
        $this->form_validation->set_rules('id_destana', 'Desa (Destana)', 'required|integer');
        $this->form_validation->set_rules('jumlah_korban', 'Jumlah Korban', 'required|integer');

        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }

        $payload = [
            'id_destana'       => (int)$this->input->post('id_destana'),
            'id_ancaman'       => $this->input->post('id_ancaman') ? (int)$this->input->post('id_ancaman') : NULL,
            'tanggal_bencana'  => $this->input->post('tanggal_bencana'),
            'jumlah_korban'    => (int)$this->input->post('jumlah_korban'),
            'detail_kerusakan' => $this->input->post('detail_kerusakan'),
        ];

        $this->bencana->update($id, $payload);
        $this->session->set_flashdata('success', 'Laporan bencana berhasil diperbarui.');
        redirect('bencana');
    }

    public function delete($id)
    {
        $this->bencana->delete($id);
        $this->session->set_flashdata('success', 'Laporan bencana berhasil dihapus.');
        redirect('bencana');
    }

    /* ===== AJAX untuk dropdown dependent ===== */

    // Ambil daftar desa (Destana) berdasarkan kecamatan → kembalikan <option>
    public function ajax_destana_options()
    {
        $id_kecamatan = $this->input->get('id_kecamatan');
        $list = $this->bencana->get_destana_by_kecamatan($id_kecamatan);

        $options = '<option value="">-- Pilih Desa (Destana) --</option>';
        foreach ($list as $r) {
            $label = $r->nama_desa . ' (' . $r->nama_kecamatan . ')';
            $options .= '<option value="'.$r->id_destana.'">'.$label.'</option>';
        }
        header('Content-Type: text/html; charset=utf-8');
        echo $options;
    }

    /* ====== API data Chart.js ====== */

    public function chart_tren()
    {
        $tahun = $this->input->get('tahun'); // optional
        $rows = $this->bencana->chart_tren_bulanan($tahun);

        $labels = [];
        $data   = [];
        foreach ($rows as $r) {
            $labels[] = $r->ym;       // YYYY-MM
            $data[]   = (int)$r->total;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['labels'=>$labels, 'data'=>$data]));
    }

    public function chart_korban_per_kecamatan()
    {
        $tahun = $this->input->get('tahun'); // optional
        $rows = $this->bencana->chart_korban_per_kecamatan($tahun);

        $labels = [];
        $data   = [];
        foreach ($rows as $r) {
            $labels[] = $r->nama_kecamatan;
            $data[]   = (int)$r->total_korban;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['labels'=>$labels, 'data'=>$data]));
    }
}
