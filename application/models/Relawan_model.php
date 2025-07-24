<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relawan_model extends CI_Model
{
    protected $table = 'relawan';

    public function get_all($id_kecamatan = null, $id_desa = null)
    {
        $this->db
            ->select('r.*, mk.nama_kecamatan, md.nama_desa')
            ->from($this->table . ' r')
            ->join('master_kecamatan mk', 'mk.id_kecamatan = r.id_kecamatan')
            ->join('master_desa md', 'md.id_desa = r.id_desa');

        if ($id_kecamatan) {
            $this->db->where('r.id_kecamatan', $id_kecamatan);
        }

        if ($id_desa) {
            $this->db->where('r.id_desa', $id_desa);
        }

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
            'kecamatan_list' => $this->db->get('master_kecamatan')->result(),
            'desa_list'      => $this->db->get('master_desa')->result(),
        ];
    }

    public function get_filtered($id_kecamatan = null, $id_desa = null)
    {
        $this->db
            ->select('r.*, mk.nama_kecamatan, md.nama_desa')
            ->from($this->table . ' r')
            ->join('master_kecamatan mk', 'mk.id_kecamatan = r.id_kecamatan')
            ->join('master_desa md', 'md.id_desa = r.id_desa');

        if (!empty($id_kecamatan)) {
            $this->db->where('r.id_kecamatan', $id_kecamatan);
        }

        if (!empty($id_desa)) {
            $this->db->where('r.id_desa', $id_desa);
        }

        return $this->db->get()->result();
    }

    public function get_kecamatan_by_kode($kode)
    {
        return $this->db->get_where('master_kecamatan', ['kode' => $kode])->row();
    }

}
