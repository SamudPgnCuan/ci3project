<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relawan_model extends CI_Model
{
    protected $table = 'relawan';

    public function get_all($id_kecamatan = null, $id_desa = null, $id_organisasi = null)
    {
        $this->db
            ->select('r.*, mk.nama_kecamatan, md.nama_desa, mo.nama_organisasi')
            ->from($this->table . ' r')
            ->join('master_kecamatan mk', 'mk.id_kecamatan = r.id_kecamatan')
            ->join('master_desa md', 'md.id_desa = r.id_desa')
            ->join('master_organisasi mo', 'mo.id_organisasi = r.id_organisasi', 'left');

        if ($id_kecamatan) {
            $this->db->where('r.id_kecamatan', $id_kecamatan);
        }

        if ($id_desa && $id_desa != 'all') { //kalo ada tapi bukan 'all', baru ambil sesuai id, all untuk opsi semua desa di dropdown
            $this->db->where('r.id_desa', $id_desa);
        }

        if ($id_organisasi) {
            $this->db->where('r.id_organisasi', $id_organisasi);
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

    public function get_master_lists() //maybe should just put this in controller? no used in index, edit, and create
    {
        return [
            'kecamatan_list' => $this->db->get('master_kecamatan')->result(),
            'desa_list'      => $this->db->get('master_desa')->result(),
            'organisasi_list'      => $this->db->get('master_organisasi')->result(),
        ];
    }

}
