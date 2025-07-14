<?php
class Destana_model extends CI_Model
{
    protected $table = 'tabeldestana';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_id($where)
    {
        return $this->db->get_where($this->table, $where)->row();
    }

    public function update($where, $data)
    {
        return $this->db->update($this->table, $data, $where);
    }

    public function delete($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
