<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function index() {
        redirect('usuarios/login');
    }

    public function login() {
        if ($this->Usuario->logueado()) {
            redirect('reservas/index');
        }

        if ($this->input->post('login') !== NULL)
        {
            $nombre = $this->input->post('nombre');

            $reglas = array(
                array(
                    'field' => 'nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|required|callback__existe_nombre',
                    'errors' => array(
                        'required' => 'Nombre o contraseña no válidos.'
                    )
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => "trim|required|callback__password_valido[$nombre]",
                    'errors' => array(
                        'required' => 'Nombre o contraseña no válidos.'
                    )
                )
            );

            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() === TRUE)
            {
                $usuario = $this->Usuario->por_nombre($nombre);
                $this->session->set_userdata('usuario', array(
                    'id' => $usuario['id_usuario'],
                    'nombre' => $nombre
                ));
                redirect('reservas/index');
            }
        }
        $this->template->load('usuarios/login');

    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('usuarios/login');
    }

    public function _existe_nombre($nombre) {
        if ($this->Usuario->por_nombre($nombre) !== FALSE)
        {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('_existe_nombre',
                'Nombre o contraseña no válidos.');
            return FALSE;
        }
    }

    public function _password_valido($password, $nombre) {
        $usuario = $this->Usuario->por_nombre($nombre);

        if ($usuario !== FALSE &&
            md5($password) === $usuario['password'])
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_password_valido',
                'Nombre o contraseña no válidos.');
            return FALSE;
        }
    }

}
