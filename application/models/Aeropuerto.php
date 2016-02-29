<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aeropuerto extends CI_Model{

    public function todos() {
        $res = $this->db->query('select * from v_vuelos');
        return $res->num_rows() > 0 ? $res->result_array() : FALSE;
    }

    public function por_id($id) {
        $res = $this->db->query('select * from v_vuelos where id = ?',
                                    array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function vuelos() {
        $res = $this->db->query('select * from v_vuelos_disponibles');
        return $res->num_rows() > 0 ? $res->result_array() : FALSE;
    }

    public function vuelo_por_id($id) {
        $res = $this->db->query('select * from v_vuelos_disponibles where id = ?',
                                    array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }
}
