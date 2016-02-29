<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Model{

  public function reservar($id_vuelo)
  {
      $usuario = $this->session->userdata('usuario');

      $this->db->query('insert into reservas (id_usuario, id_vuelo) values (?, ?)',
                            array($usuario['id'], $id_vuelo));
  }

  public function anular($id_vuelo)
  {
      $usuario = $this->session->userdata('usuario');

      $this->db->query('delete from reservas where id_usuario = ? AND id_vuelo = ?',
                            array($usuario['id'], $id_vuelo));
  }

  public function por_id($id)
  {
      $res = $this->db->query("select id_vuelo from reservas where id_usuario = ?",
                                array($id));

      $res = $res->num_rows() > 0 ? $res->result_array() : FALSE;
      $reservas = array();
      if ($res === FALSE) return FALSE;
      foreach ($res as $reserva)
      {
         $reservas[] = $this->db->query("select * from v_vuelos where id = ?",
                                   array($reserva['id_vuelo']))->row_array();
      }
      return $reservas;
  }

}
