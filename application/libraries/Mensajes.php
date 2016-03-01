<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes {

    public function push_info($nuevo) {
        $CI =& get_instance();
        $mensajes = $CI->session->flashdata('mensajes');
        $mensajes = isset($mensajes) ? $mensajes : array();
        $mensajes[] = array('info' => $nuevo);
        $CI->session->set_flashdata('mensajes', $mensajes);
    }
}
