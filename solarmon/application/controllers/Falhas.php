<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Falhas extends CI_Controller {

 
    public function index() {
        $output["falhas"] = $this->getFalhas();
        $this->template->set("menu", "Falhas");
        $this->template->set("submenu", "sistema");
        $this->template->load('templates/index', "falhas/index", $output);
    }
    
    public function getFalhas(){
        $this->db->select("mensagem, categoria");
        $this->db->where("planta_idplanta", 1);
        $this->db->group_by("planta_idplanta, mensagem, categoria");
        return $this->db->get("falhas")->result();
    }
    
    public function count_falhas(){
        $this->db->select("mensagem, categoria");
        $this->db->where("planta_idplanta", 1);
        $this->db->group_by("planta_idplanta, mensagem, categoria");
        $query = $this->db->get("falhas");
        echo $query->num_rows();
    }

}
