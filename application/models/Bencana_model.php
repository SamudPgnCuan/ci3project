<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bencana_model extends CI_Model
{
    private $table = 'bencana';

    public function list($filters = [])
    {
        $this->db->select("
            bencana.*,
            md.nama_desa,
            mk.nama_kecamatan,
            ma.nama_ancaman,
            u.nama AS nama_pembuat
        ");
        $this->db->from("$this->table AS bencana");
        $this->db->join('destana d', 'd.id = bencana.id_destana');
        $this->db->join('master_desa md', 'md.id_desa = d.id_desa');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan'); // ✅ FIX
        $this->db->join('master_ancaman ma', 'ma.id_ancaman = bencana.id_ancaman', 'left');
        $this->db->join('users u', 'u.id = bencana.created_by');

        // Filter dinamis
        if (!empty($filters['id_kecamatan'])) {
            $this->db->where('mk.id_kecamatan', $filters['id_kecamatan']);
        }
        if (!empty($filters['id_desa'])) {
            $this->db->where('md.id_desa', $filters['id_desa']);
        }
        if (!empty($filters['id_ancaman'])) {
            $this->db->where('bencana.id_ancaman', $filters['id_ancaman']);
        }
        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where('bencana.tanggal_bencana >=', $filters['tanggal_mulai']);
        }
        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where('bencana.tanggal_bencana <=', $filters['tanggal_selesai'] . ' 23:59:59');
        }

        $this->db->order_by('bencana.tanggal_bencana', 'DESC');
        return $this->db->get()->result();
    }

    public function find($id)
    {
        $this->db->select("
            bencana.*,
            d.id AS id_destana,
            md.id_desa, md.nama_desa,
            mk.id_kecamatan, mk.nama_kecamatan,
            ma.nama_ancaman
        ");
        $this->db->from("$this->table AS bencana");
        $this->db->join('destana d', 'd.id = bencana.id_destana');
        $this->db->join('master_desa md', 'md.id_desa = d.id_desa');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan'); // ✅ FIX
        $this->db->join('master_ancaman ma', 'ma.id_ancaman = bencana.id_ancaman', 'left');
        $this->db->where('bencana.id', $id);

        return $this->db->get()->row();
    }


    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete($this->table);
        return $this->db->affected_rows();
    }

    // Utilitas untuk dropdown filter
    public function get_kecamatan_all()
    {
        return $this->db->order_by('nama_kecamatan','ASC')->get('master_kecamatan')->result();
    }

    public function get_ancaman_all()
    {
        return $this->db->order_by('nama_ancaman','ASC')->get('master_ancaman')->result();
    }

    // Ambil desa yang HANYA muncul di tabel destana (desa yang terdaftar sbg Destana)
    public function get_desa_by_kecamatan($id_kecamatan)
    {
        $this->db->select('md.id_desa, md.nama_desa');
        $this->db->from('destana d');
        $this->db->join('master_desa md', 'md.id_desa = d.id_desa');
        $this->db->where('d.id_kecamatan', $id_kecamatan);
        $this->db->order_by('md.nama_desa', 'ASC');
        return $this->db->get()->result();
    }

    // Ambil pasangan id_destana + label "Desa (Kec)" untuk form create
    public function get_destana_by_kecamatan($id_kecamatan = null)
    {
        $this->db->select('d.id AS id_destana, md.nama_desa, mk.nama_kecamatan');
        $this->db->from('destana d');
        $this->db->join('master_desa md', 'md.id_desa = d.id_desa');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan');
        if (!empty($id_kecamatan)) {
            $this->db->where('mk.id_kecamatan', $id_kecamatan);
        }
        $this->db->order_by('mk.nama_kecamatan ASC, md.nama_desa ASC');
        return $this->db->get()->result();
    }

    /* ====== DATA UNTUK CHART ====== */

    // Tren jumlah kejadian per bulan (count report)
    public function chart_tren_bulanan($tahun = null)
    {
        if ($tahun) {
            $this->db->where('YEAR(tanggal_bencana)', $tahun);
        }
        $this->db->select('DATE_FORMAT(tanggal_bencana, "%Y-%m") AS ym, COUNT(*) AS total');
        $this->db->from($this->table);
        $this->db->group_by('ym');
        $this->db->order_by('ym', 'ASC');
        return $this->db->get()->result();
    }

    // Total korban per kecamatan
    public function chart_korban_per_kecamatan($tahun = null)
    {
        $this->db->select('mk.nama_kecamatan, SUM(b.jumlah_korban) AS total_korban');
        $this->db->from("$this->table b");
        $this->db->join('destana d', 'd.id = b.id_destana');
        $this->db->join('master_desa md', 'md.id_desa = d.id_desa');
        $this->db->join('master_kecamatan mk', 'mk.id_kecamatan = d.id_kecamatan');
        if ($tahun) {
            $this->db->where('YEAR(b.tanggal_bencana)', $tahun);
        }
        $this->db->group_by('mk.id_kecamatan');
        $this->db->order_by('mk.nama_kecamatan','ASC');
        return $this->db->get()->result();
    }
}
