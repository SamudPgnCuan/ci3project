<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destana_ancaman_model extends CI_Model
{
    protected $table = 'destana_ancaman';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    public function delete_by_destana($id_destana)
    {
        return $this->db->delete($this->table, ['id_destana' => $id_destana]);
    }

    public function get_by_destana($id_destana) //did i end up using this?
    {
        $this->db->select('ma.nama_ancaman');
        $this->db->from($this->table . ' da');
        $this->db->join('master_ancaman ma', 'da.id_ancaman = ma.id_ancaman');
        $this->db->where('da.id_destana', $id_destana);
        return array_column($this->db->get()->result_array(), 'nama_ancaman');
    }

    public function get_ancaman_ids_by_destana($id_destana)
    {
        $this->db->select('id_ancaman');
        $this->db->from('destana_ancaman');
        $this->db->where('id_destana', $id_destana);
        $query = $this->db->get();
        return array_column($query->result_array(), 'id_ancaman');
    }

}
