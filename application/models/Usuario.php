<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model{

    public function logueado()
    {
        return $this->session->has_userdata('usuario');
    }

    public function por_nombre($nombre)
    {
        $res = $this->db->query('select * from usuarios where nombre = ?',
                                    array($nombre));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }
}
