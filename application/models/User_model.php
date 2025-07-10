<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'TabelUser';

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_username($username) {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($username, $data) {
        $this->db->where('username', $username);
        return $this->db->update($this->table, $data);
    }

    public function delete($username) {
        return $this->db->delete($this->table, ['username' => $username]);
    }
}
