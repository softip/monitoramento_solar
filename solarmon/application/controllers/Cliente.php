<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function index() {
        //config tabela
        $crud = new grocery_CRUD();
        $crud->set_table('cliente');                
        $crud->set_subject('Cliente');
        
        //renomear        
        $crud->display_as("cpf", "CPF");
        
        //colunas
        $crud->columns("nome", "cpf", "fone");
        
        //campos obrigatorios
        $crud->required_fields("nome", "cpf", "email", "senha");
        
        //configurações nos atributos
        $crud->set_field_upload("foto", "assets/uploads/clientes");     
        $crud->field_type("senha", "password");
        
        //adicionando novas ações
        $crud->add_action("Intalações", null, site_url("planta/index/"), "fa fa-home fa-lg gicon");
        
        
        $crud->unset_clone();
        $output = $crud->render();
        
        //envio de dados para template
        $this->template->set("menu", "Cadastros");
        $this->template->set("submenu", "cliente");
        $this->template->load('templates/index', "crud/index", $output);
    }

    public function index2() {
        $this->template->load('templates/index', "content/index2");
    }

}
