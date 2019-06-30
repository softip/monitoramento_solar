<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $this->load->view("login/index");
    }

    public function verificar() {
        $email = $this->input->post("email");
        $senha = $this->input->post("senha");

        $this->db->where("email", $email);
        $this->db->where("senha", $senha);
        $query = $this->db->get("cliente");

        if ($query->num_rows() == 1) {
            $user = $query->row(); 
            $usuario = array(
                'nome' => $user->nome,
                'email' => $user->email,
                'foto' => $user->foto,
                'logged' => TRUE
            );
            $this->session->set_userdata("user", $usuario);
            redirect(site_url('cliente'));
        } else {
            $this->session->set_flashdata('erro', 'Usuário ou senha inválidos');
            redirect(site_url('login/index'));
        }
    }

}
