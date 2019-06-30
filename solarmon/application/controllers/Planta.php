<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Planta extends CI_Controller {

    public function index($idcliente="") {
        //config tabela
        $crud = new grocery_CRUD();
        $crud->set_table('planta');  
        $crud->set_subject('Instalação');
        
        //config fields     
        $crud->required_fields("fabricante");
        $crud->set_field_upload("foto", "assets/uploads/plantas");
        $crud->display_as("cliente_idcliente", "Cliente");
        
        
        //adicionando novas ações
        $crud->add_action("Painéis Fotovoltaicos", null, site_url("placas/index/"), "fa fa-th gicon");
        $crud->add_action("Energia produzida", null, site_url("energia_gerada/index/"), "fa fa-bolt gicon");
        
        
        //filtragem
        if(!empty($idcliente) && is_numeric($idcliente)){
            $crud->where("cliente_idcliente", $idcliente);
            $crud->field_type("cliente_idcliente", "hidden", $idcliente);
             $crud->columns("sistema", "local", "endereco");
        }else{
            $crud->set_relation("cliente_idcliente", "cliente", "nome");
            $crud->columns("cliente_idcliente", "sistema", "local", "endereco");
        }
        
        $crud->unset_clone();
        $output = $crud->render();
        
        //envio de dados para template
        $this->template->set("menu", "Cadastros");
        $this->template->set("submenu", "instalações");
        $this->template->load('templates/index', "crud/index", $output);
    }

    public function index2() {
        $this->template->load('templates/index', "content/index2");
    }

}
