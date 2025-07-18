<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Destana_model extends CI_Model {

    protected $table = 'destana';

    public function get_all() {
        $this->db->select('
            d.id,
            mk.nama_kecamatan,
            md.nama_desa,
            d.tahun_pembentukan,
            mkls.nama_kelas,
            msd.nama_sumber_dana
        ');
        $this->db->from($this->table . ' d');
        $this->db->join('master_kecamatan mk', 'd.id_kecamatan = mk.id_kecamatan', 'left');
        $this->db->join('master_desa md', 'd.id_desa = md.id_desa', 'left');
        $this->db->join('master_kelas mkls', 'd.id_kelas = mkls.id_kelas', 'left');
        $this->db->join('master_sumber_dana msd', 'd.id_sumber_dana = msd.id_sumber_dana', 'left');
        $query = $this->db->get();
        $result = $query->result_array();

        
        foreach ($result as &$row) {
            $row['ancaman'] = $this->get_nama_ancaman_by_destana($row['id']);
        }

        return $result;
    }

    public function get_nama_ancaman_by_destana($id_destana) {
        $this->db->select('ma.nama_ancaman');
        $this->db->from('destana_ancaman da');
        $this->db->join('master_ancaman ma', 'da.id_ancaman = ma.id_ancaman', 'left');
        $this->db->where('da.id_destana', $id_destana);
        $query = $this->db->get();
        return array_column($query->result_array(), 'nama_ancaman');
    }


    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function insert_id() {
        return $this->db->insert_id();
    }

    public function update($where, $data) {
        return $this->db->update($this->table, $data, $where);
    }

    public function delete($where) {
        return $this->db->delete($this->table, $where);
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    public function get_master_lists($exclude_used_desa = false)
    {
        return [
            'kecamatan_list'   => $this->db->get('master_kecamatan')->result(),
            'desa_list'        => $exclude_used_desa ? $this->get_desa_yang_belum_dipakai() : $this->db->get('master_desa')->result(),
            'kelas_list'       => $this->db->get('master_kelas')->result(),
            'sumber_dana_list' => $this->db->get('master_sumber_dana')->result(),
            'ancaman_list'     => $this->db->get('master_ancaman')->result()
        ];
    }


    public function get_desa_yang_belum_dipakai($kd_kec = null)
    {
        $this->db->select('md.*');
        $this->db->from('master_desa md');
        $this->db->join('destana d', 'md.id_desa = d.id_desa', 'left');
        $this->db->where('d.id_desa IS NULL');
        if ($kd_kec !== null) {
            $this->db->where('md.kd_kec', $kd_kec);
        }
        return $this->db->get()->result();
    }


    public function get_desa_yang_belum_dipakai_plus_aktif($id_desa_aktif)
    {
        $this->db->select('md.*');
        $this->db->from('master_desa md');
        $this->db->join('destana d', 'md.id_desa = d.id_desa AND md.id_desa != ' . (int)$id_desa_aktif, 'left');
        $this->db->where('d.id_desa IS NULL');
        
        $desa_baru = $this->db->get()->result();
        $desa_aktif = $this->db
            ->get_where('master_desa', ['id_desa' => $id_desa_aktif])
            ->result();

        return array_merge($desa_aktif, $desa_baru);
    }


    public function get_master_lists_for_edit($id_desa_aktif)
    {
        return [
            'kecamatan_list'   => $this->db->get('master_kecamatan')->result(),
            'desa_list'        => $this->get_desa_yang_belum_dipakai_plus_aktif($id_desa_aktif),
            'kelas_list'       => $this->db->get('master_kelas')->result(),
            'sumber_dana_list' => $this->db->get('master_sumber_dana')->result(),
            'ancaman_list'     => $this->db->get('master_ancaman')->result()
        ];
    }




}
