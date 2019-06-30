<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Placas extends CI_Controller {

    public function index($idplanta = "") {
        $crud = new grocery_CRUD();
        $crud->set_table('placas');  
        $crud->set_subject('Painéis fotovoltaicos');
        
        //config dos fields
        $crud->display_as("planta_idplanta", "Local de instalação");
        $crud->display_as("potencia_maxima", "Potência máxima(W)(<i>P<sub>max</sub>)</i>");
        $crud->display_as("potencia_minima", "Potência mínima(W) (<i>P<sub>min</sub>)</i>");
        $crud->display_as("corrente_maxima", "Corrente máxima(A) (<i>I<sub>max</sub>)</i>");
        $crud->display_as("tensao_maxima", "Tensão máxima(V) (<i>V<sub>max</sub>)</i>");
        $crud->display_as("corrente_curto_circuito", "Corrente curto-circuito(A) (<i>I<sub>CC</sub>)</i>");
        $crud->display_as("tensao_circuito_aberto", "Tensão circuito aberto(V) (<i>V<sub>CC</sub>)</i>");
        $crud->display_as("tensao_max_admissivel", "Tensão máxima admissível(V) (<i>V<sub>adm</sub>)</i>");
        $crud->display_as("coeficiente_termico_tensao", "Coeficiente térmico para tensão (%)");
        $crud->display_as("coeficiente_termico_corrente", "Coeficiente térmico para corrente (%)");
        $crud->display_as("eficiencia", "Eficiência <i>(&eta;)</i> %");
        $crud->columns("fabricante", "potencia_maxima", "tensao_maxima", "eficiencia");
        $crud->required_fields("fabricante", "planta_idplanta", "potencia_maxima", "tensao_maxima", "eficiencia");
        
        
        //filtragem
        if(!empty($idplanta) && is_numeric($idplanta)){
            $crud->where("planta_idplanta", $idplanta);
            $crud->field_type("planta_idplanta", "hidden", $idplanta);
            //$crud->columns("sistema", "local", "endereco");
        }else{
            $crud->set_relation("planta_idplanta", "planta", "local");
            //$crud->columns("cliente_idcliente", "sistema", "local", "endereco");
        }
        
        $crud->unset_clone();
        $output = $crud->render();
        
        $this->template->set("menu", "Cadastros");
        $this->template->set("submenu", "Painéis fotovoltaicos");
        $this->template->load('templates/index', "crud/index", $output);
    }

    public function index2() {
        $this->template->load('templates/index', "content/index2");
    }

}
