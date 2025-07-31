<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Destana_model extends CI_Model {

    protected $table = 'destana';

    public function get_all($filter = [])
    {
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

        if ($filter['id_kecamatan']) {
            $this->db->where('d.id_kecamatan', $filter['id_kecamatan']);
        }
        if ($filter['id_desa']) {
            $this->db->where('d.id_desa', $filter['id_desa']);
        }
        if ($filter['tahun']) {
            $this->db->where('d.tahun_pembentukan', $filter['tahun']);
        }
        if ($filter['id_kelas']) {
            $this->db->where('d.id_kelas', $filter['id_kelas']);
        }
        if ($filter['id_sumber_dana']) {
            $this->db->where('d.id_sumber_dana', $filter['id_sumber_dana']);
        }

        // filter ancaman
        if ($filter['id_ancaman']) {
            $this->db->where("EXISTS (
                SELECT 1 FROM destana_ancaman da
                WHERE da.id_destana = d.id
                AND da.id_ancaman = " . $this->db->escape($filter['id_ancaman']) . "
            )", null, false);
        }

        $this->db->order_by('md.id_desa', 'asc');

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

    public function get_master_lists($exclude_used_desa = false, $id_desa_aktif = null)
{
    return [
        'kecamatan_list'   => $this->db->get('master_kecamatan')->result(),
        'desa_list'        => $exclude_used_desa ? 
                              $this->get_desa_unused(null, $id_desa_aktif) 
                            : $this->db->get('master_desa')->result(),
        'kelas_list'       => $this->db->get('master_kelas')->result(),
        'sumber_dana_list' => $this->db->get('master_sumber_dana')->result(),
        'ancaman_list'     => $this->db->get('master_ancaman')->result()
    ];
}


    /**
 * Ambil daftar desa yang belum digunakan di tabel destana.
 * Jika `$id_desa_aktif` diset, maka desa tersebut tetap disertakan.
 *
 * @param string|null $kd_kec         Kode kecamatan untuk filter desa (opsional).
 * @param int|null    $id_desa_aktif  ID desa yang sedang aktif digunakan (opsional).
 * @return array                      Daftar desa yang tersedia.
 */
    public function get_desa_unused($kd_kec = null, $id_desa_aktif = null)
    {
        $this->db->select('md.*');
        $this->db->from('master_desa md');
        $this->db->join('destana d', 'md.id_desa = d.id_desa AND md.id_desa != ' . (int)$id_desa_aktif, 'left', false);
        $this->db->where('d.id_desa IS NULL');
        if ($kd_kec !== null) {
            $this->db->where('md.kd_kec', $kd_kec);
        }
        $desa_baru = $this->db->get()->result();

        if ($id_desa_aktif !== null) {
            $desa_aktif = $this->db
                ->get_where('master_desa', ['id_desa' => $id_desa_aktif])
                ->result();
            return array_merge($desa_aktif, $desa_baru);
        }

        return $desa_baru;
    }




}
