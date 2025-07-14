<?php

/**
 * @property Relawan_model $Relawan_model
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Relawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Relawan_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
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
        $this->load_template('relawan_form', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]', [
            'regex_match' => 'Format Tanggal Lahir harus YYYY-MM-DD',
        ]);
        $this->form_validation->set_rules('komunitas', 'Komunitas', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['relawan'] = (object) $this->input->post();
            $this->load_template('relawan_form', $data);
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'nik' => $this->input->post('nik'),
                'alamat' => $this->input->post('alamat'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'komunitas' => $this->input->post('komunitas'),
                'no_hp' => $this->input->post('no_hp'),
            ];
            $this->Relawan_model->insert($data);
            redirect('relawan');
        }
    }

    public function edit($nik)
    {
        $data['relawan'] = $this->Relawan_model->get_by_nik($nik);
        $this->load_template('relawan_form', $data);
    }

    public function update($nik)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]', [
            'regex_match' => 'Format Tanggal Lahir harus YYYY-MM-DD',
        ]);
        $this->form_validation->set_rules('komunitas', 'Komunitas', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['relawan'] = (object) $this->input->post();
            $data['relawan']->nik = $nik; // mempertahankan NIK lama
            $this->load_template('relawan_form', $data);
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'nik' => $this->input->post('nik'),
                'alamat' => $this->input->post('alamat'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'komunitas' => $this->input->post('komunitas'),
                'no_hp' => $this->input->post('no_hp'),
            ];
            $this->Relawan_model->update($nik, $data);
            redirect('relawan');
        }
    }

    public function delete($nik)
    {
        $this->Relawan_model->delete($nik);
        redirect('relawan');
    }
}
