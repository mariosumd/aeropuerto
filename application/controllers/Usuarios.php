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
            $email = $this->input->post('email');

            $reglas = array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|callback__existe_email',
                    'errors' => array(
                        'required' => 'Email o contraseña no válidos.'
                    )
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => "trim|required|callback__password_valido[$email]",
                    'errors' => array(
                        'required' => 'Email o contraseña no válidos.'
                    )
                )
            );

            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() === TRUE)
            {
                $usuario = $this->Usuario->por_email($email);
                $this->session->set_userdata('usuario', array(
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre']
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

    public function _existe_email($email) {
        if ($this->Usuario->por_email($email) !== FALSE)
        {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('_existe_email',
                'Email o contraseña no válidos.');
            return FALSE;
        }
    }

    public function _password_valido($password, $email) {
        $usuario = $this->Usuario->por_email($email);

        if ($usuario !== FALSE &&
            password_verify($password, $usuario['password']) === TRUE)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_password_valido',
                'Email o contraseña no válidos.');
            return FALSE;
        }
    }

}
