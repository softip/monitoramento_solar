<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Medicao extends CI_Controller {

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('medicao');
        $crud->required_fields("local");
        $crud->set_subject('Medição');
        $crud->set_relation("planta_idplanta", "cliente", "nome");
        $output = $crud->render();
        $this->template->load('templates/index', "crud/index", $output);
    }

    public function index2() {
        $this->template->load('templates/index', "content/index2");
    }
    
    public function teste(){
        $tempo1 =  strtotime("2019-06-24 UTC");
        
        $tempo2 = strtotime("2019-06-24 19:40:36");
        
        $tempo3 = $tempo2 - $tempo1;
        
        echo $tempo1;
        echo "<br />";
        echo $tempo2;
        echo "<br />";
        echo $tempo3;
        echo "<br />";
    }

}
