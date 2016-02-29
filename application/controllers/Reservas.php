<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservas extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    if ( ! $this->Usuario->logueado())
    {
        redirect('usuarios/login');
    }
  }

  public function index()
  {
      $data['usuario']  = $this->session->userdata('usuario');
      $data['vuelos']   = $this->Aeropuerto->vuelos();
      $data['reservas'] = $this->Reserva->por_id($data['usuario']['id']);
      $this->template->load('reservas/index', $data);
  }

  public function anula()
  {
      if ($this->input->post('anular') !== NULL)
      {
          $id_vuelo = $this->input->post('id_vuelo');
          $data['vuelo'] = $this->Aeropuerto->por_id($id_vuelo);
          $this->template->load('reservas/anula', $data);
      }
      elseif ($this->input->post('confirmar') !== NULL)
      {
          $id_vuelo = $this->input->post('id_vuelo');
          $this->Reserva->anular($id_vuelo);
          redirect('reservas/index');
      }
      else
      {
          redirect('reservas/index');
      }
  }

  public function reserva()
  {
        if ($this->input->post('reservar') !== NULL)
        {
            $id = $this->input->post('vuelo');
            $data['vuelo'] = $this->Aeropuerto->vuelo_por_id($id);
            $this->template->load("reservas/reserva", $data);
        }
        elseif ($this->input->post('confirmar') !== NULL)
        {
            $id_vuelo = $this->input->post('id_vuelo');
            $this->Reserva->reservar($id_vuelo);
            redirect('reservas/index');
        }
        else
        {
            redirect('reservas/index');
        }
    }
}
