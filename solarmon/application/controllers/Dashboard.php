<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index() {  
        $this->template->set("menu", "Monitoramento");
        $this->template->set("submenu", "planta 1");
        $this->template->load('templates/index', "dashboard/index");
    }
    
    public function index2() {  
        //$this->template->set("menu", "Monitoramento");
        //$this->template->set("submenu", "planta 1");
        $this->load->view("index");
    }
}
