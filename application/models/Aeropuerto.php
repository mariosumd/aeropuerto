<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aeropuerto extends CI_Model{

    public function todos() {
        $res = $this->db->query('select * from v_vuelos');
        return $res->num_rows() > 0 ? $res->result_array() : FALSE;
    }

    public function por_id($id) {
        $res = $this->db->query('select * from v_vuelos where vuelo = ?',
                                    array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function vuelos() {
        $res = $this->db->query('select * from v_vuelos_disponibles');
        return $res->num_rows() > 0 ? $res->result_array() : FALSE;
    }

    public function vuelo_por_id($id) {
        $res = $this->db->query('select * from v_vuelos_disponibles where vuelo = ?',
                                    array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function asientos($id_vuelo) {
        $asientos = $this->db->query('select plazas from vuelos where id_vuelo = ?',
                                        array($id_vuelo))->row_array()['plazas'];

        $libres = array();

        for ($i = 1; $i <= $asientos; $i++) {
            if ( ! $this->Reserva->asiento_ocupado($id_vuelo, $i))
            {
                $libres[$i] = $i;
            }
        }
        return $libres !== array() ? $libres : FALSE;
    }
}
