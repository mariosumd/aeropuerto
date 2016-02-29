<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model{

    public function logueado()
    {
        return $this->session->has_userdata('usuario');
    }

    public function por_email($email)
    {
        $res = $this->db->get_where('usuarios', array('email' => $email));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function existe_email($email)
    {
        return $this->por_email($email) !== FALSE;
    }
}
