<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Model{

  public function reservar($id_vuelo, $asiento)
  {
      $usuario = $this->session->userdata('usuario');

      $this->db->query('insert into reservas (id_usuario, id_vuelo, asiento, fecha_hora)
                        values (?, ?, ?, current_timestamp)',
                            array($usuario['id'], $id_vuelo, $asiento));
  }

  public function anular($id_reserva)
  {
      $this->db->query('delete from reservas where id_reserva = ?',
                            array($id_reserva));
  }

  public function asiento_ocupado($vuelo_id, $asiento)
  {
      $res = $this->db->query("select * from reservas where id_vuelo = ? AND asiento = ?",
                                array($vuelo_id, $asiento));

      return $res->num_rows() > 0;
  }

  public function por_id($id)
  {

      $res = $this->db->query("select id_reserva, id_vuelo, asiento,
                                   to_char(fecha_hora, 'DD/MM/YYY HH:MI') as comprada
                                 from reservas where id_usuario = ?",
                                array($id));

      $res = $res->num_rows() > 0 ? $res->result_array() : FALSE;
      $reservas = array();
      if ($res === FALSE) return FALSE;
      foreach ($res as $reserva)
      {
         $reservas[] = $this->db->query("select *, ? as asiento, ? as id_reserva,
                                               ? as comprada
                                           from v_vuelos where vuelo = ?",
                                   array($reserva['asiento'], $reserva['id_reserva'],
                                         $reserva['comprada'],
                                         $reserva['id_vuelo']))->row_array();
      }
      return $reservas;
  }

  public function por_reserva($id_reserva)
  {
      $res = $this->db->query("select id_vuelo, asiento,
                                   to_char(fecha_hora, 'DD/MM/YYY HH:MI') as comprada
                                 from reservas where id_reserva = ?",
                                array($id_reserva));

      $res = $res->num_rows() > 0 ? $res->row_array() : FALSE;
      if ($res === FALSE) return FALSE;
      $reserva = $this->db->query("select *, ? as asiento, ? as id_reserva, ? as comprada
                                     from v_vuelos where vuelo = ?",
                                   array($res['asiento'], $id_reserva, $res['comprada'],
                                            $res['id_vuelo']))->row_array();
      return $reserva;
  }

}
