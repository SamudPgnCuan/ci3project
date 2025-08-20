<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bencana_model extends CI_Model {

    protected $table = 'bencana';

    public function get_all($filter = [])
    {
        $this->db->select('
            b.id,
            b.tanggal_bencana,
            b.jumlah_korban,
            mk.nama_kecamatan,
            md.nama_desa,
            ma.nama_ancaman,
            u.nama AS nama_pembuat
        ');
        $this->db->from($this->table . ' b');
        $this->db->join('destana d', 'd.id = b.id_destana', 'left');
        $this->db->join('master_desa md', 'd.id_desa = md.id_desa', 'left');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan', 'left'); 
        $this->db->join('master_ancaman ma', 'b.id_ancaman = ma.id_ancaman', 'left');
        $this->db->join('users u', 'u.id = b.created_by', 'left');

        if (!empty($filter['id_kecamatan'])) {
            $this->db->where('mk.id_kecamatan', $filter['id_kecamatan']);
        }
        if (!empty($filter['id_desa'])) {
            $this->db->where('md.id_desa', $filter['id_desa']);
        }
        if (!empty($filter['id_ancaman'])) {
            $this->db->where('b.id_ancaman', $filter['id_ancaman']);
        }
        if (!empty($filter['tanggal_mulai'])) {
            $this->db->where('b.tanggal_bencana >=', $filter['tanggal_mulai']);
        }
        if (!empty($filter['tanggal_selesai'])) {
            $this->db->where('b.tanggal_bencana <=', $filter['tanggal_selesai'] . ' 23:59:59');
        }

        $this->db->order_by('b.tanggal_bencana', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('b.id', $id);
        $this->db->select('b.*, md.id_desa, d.id_kecamatan'); 
        $this->db->from($this->table . ' b');
        $this->db->join('destana d', 'd.id = b.id_destana', 'left');
        $this->db->join('master_desa md', 'd.id_desa = md.id_desa', 'left');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan', 'left'); 
        return $this->db->get()->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($where, $data) {
        return $this->db->update($this->table, $data, $where);
    }

    public function delete($where) {
        return $this->db->delete($this->table, $where);
    }

    public function get_master_lists()
    {
        return [
            'kecamatan_list' => $this->db->get('master_kecamatan')->result(),
            'desa_list'      => $this->db->get('master_desa')->result(),
            'ancaman_list'   => $this->db->get('master_ancaman')->result()
        ];
    }

    public function get_destana_by_kecamatan($id_kecamatan = null)
    {
        $this->db->select('d.id AS id_destana, d.id_kecamatan, md.nama_desa, mk.nama_kecamatan');
        $this->db->from('destana d');
        $this->db->join('master_desa md', 'md.id_desa = d.id_desa');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan');
        
        if (!empty($id_kecamatan)) {
            $this->db->where('d.id_kecamatan', $id_kecamatan);
        }

        $this->db->order_by('mk.nama_kecamatan ASC, md.nama_desa ASC');
        return $this->db->get()->result();
    }
}
