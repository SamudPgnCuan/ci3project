<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relawan_model extends CI_Model
{
    protected $table = 'relawan';

    public function get_all($filter = [])
    {
        $this->db->select('r.*, mk.nama_kecamatan, md.nama_desa, mo.nama_organisasi');
        $this->db->from($this->table . ' r');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = r.id_kecamatan', 'left');
        $this->db->join('master_desa md', 'md.id_desa = r.id_desa', 'left');
        $this->db->join('master_organisasi mo', 'mo.id_organisasi = r.id_organisasi', 'left');

        if (!empty($filter['id_kecamatan'])) {
            $this->db->where('r.id_kecamatan', $filter['id_kecamatan']);
        }

        if (!empty($filter['id_desa'])) {
            $this->db->where('r.id_desa', $filter['id_desa']);
        }

        if (!empty($filter['id_organisasi'])) {
            $this->db->where('r.id_organisasi', $filter['id_organisasi']);
        }

        $this->db->order_by('r.id_kecamatan', 'asc');
        $this->db->order_by('r.id_desa', 'asc');

        return $this->db->get()->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_id($id)
    {
        return $this->db
            ->select('r.*')
            ->from($this->table . ' r')
            ->where('r.id', $id)
            ->get()
            ->row();
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_master_lists()
    {
        return [
            'kecamatan_list'  => $this->db->get('master_kecamatan')->result(),
            'desa_list'       => $this->db->get('master_desa')->result(),
            'organisasi_list' => $this->db->get('master_organisasi')->result(),
        ];
    }
}
