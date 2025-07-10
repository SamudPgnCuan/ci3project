<?php
class Relawan_model extends CI_Model
{
    protected $table = 'tabelrelawan';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_nik($nik)
    {
        return $this->db->get_where($this->table, ['nik' => $nik])->row();
    }

    public function update($nik, $data)
    {
        return $this->db->update($this->table, $data, ['nik' => $nik]);
    }

    public function delete($nik)
    {
        return $this->db->delete($this->table, ['nik' => $nik]);
    }
}
