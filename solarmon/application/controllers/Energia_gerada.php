<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Energia_gerada extends CI_Controller {

    
    function __construct() {
        parent::__construct();
        $this->api_weather = ""; //informar a chave obtida pelo openweathermap
    }
    
    public function index($idplanta = "") {
        $planta = $this->_findPlanta($idplanta);              
        $output["foto"] = $planta->foto;
        $output["endereco"] = $planta->endereco;        
        $json_forecast = $this->_forecast($planta->latitude, $planta->longitude);
        $json_weather = $this->_weather($planta->latitude, $planta->longitude);
        $proximos_dias = $this->getTemp2Days($json_forecast);        
        $output["previsao_hoje"] = $this->extrair_previsaoHoje($json_weather);// array_slice($proximos_dias, 0, 1)[0];        
        $output["previsao_2dias"] = array_slice($proximos_dias, 1, 2);
        $this->template->set("potencia_maxima", $this->getPotenciaPlanta($idplanta));
        $this->template->set("menu", "Monitoramento");
        $this->template->set("submenu", $planta->local);
        $this->template->load('templates/index', "energia_gerada/index", $output);
    }
    
    public function teste(){
        $this->load->view('templates/timeserie');
    }
    
    public function getPotenciaPlanta($idplanta){
        $this->db->select_sum('potencia_maxima');
        $this->db->where("planta_idplanta", $idplanta);
        $query = $this->db->get('placas')->row()->potencia_maxima;        
        return $query;         
    }

    function get_potencia(){
        $dados  = $this->db->get("medicao")->result();
        echo end($dados)->potencia;
    }
    
    function get_potencia_realtime(){
        $this->db->select("potencia, timestamp");
        $resultado = $this->db->get("medicao_realtime")->row();
        //$dados = array("t"=>date('D, d M y H:i:s',strtotime($resultado->timestamp))." +000", "y"=> floatval($resultado->potencia));
        $dados = array((strtotime(date('Y-m-d H:i:s', time()))*1000), floatval($resultado->potencia));
        echo json_encode($dados);
    }

    
    function get_energia($instalacao){
        $this->db->where("planta_idplanta", $instalacao);
        $dados  = $this->db->get("medicao_realtime")->row();
        $var = array(
            "geracao" => number_format($dados->energia/3600000, 2,',', '.'), 
            "preco" => number_format($dados->energia/3600000*0.52, 2, ',', '.'), 
            "potencia_atual" => round($dados->potencia,2), 
            "hora_atualizacao" => date('d/m/Y H:i:s',strtotime($dados->timestamp)), 
            "arvores" => number_format(0.000504 * $dados->energia/3600000,3,',','.'),
            "corrente" => number_format($dados->corrente, 2,',','.'),
            "tensao" => number_format($dados->tensao, 2,',','.'),
            "temperatura" => number_format($dados->temperatura, 2,',','.'),
            "rssid" => $dados->rssii,
            "rssiu" => $dados->rssiu            
        );
        $json = json_encode($var);
        echo $json;
    }
    

    public function _findPlanta($idplanta) {
        $this->db->where("idplanta", $idplanta);
        return $this->db->get("planta")->row();
    }

    public function _weather($latitude, $longitude) {        
        $urlforcast = "http://api.openweathermap.org/data/2.5/weather?lat=$latitude&lon=$longitude&units=metric&cnt=24&appid=$this->api_weather";
        $json = file_get_contents($urlforcast);
        return $json;        
    }
    
    public function _forecast($latitude, $longitude) {        
        $urlforcast = "http://api.openweathermap.org/data/2.5/forecast?lat=$latitude&lon=$longitude&units=metric&cnt=24&appid=$this->api_weather";
        $json = file_get_contents($urlforcast);
        return $json;        
    }
           
    function extrair_previsaoHoje($json){
        $dados = json_decode($json, true);
        $output = array("data"=> $dados["dt"], "temp"=>$dados["main"]["temp"], "min"=>$dados["main"]["temp_min"], "max"=>$dados["main"]["temp_max"], "icone" => $dados["weather"][0]["icon"].".png" );
        return $output;
    }
    
    function getTemp2Days($json){        
       $lista = json_decode($json, true)['list'];     
       $dias = array();
       foreach($lista as $value){
           $var = explode(" ", $value['dt_txt']);          
           if (!array_key_exists($var[0], $dias)){
               $dias[$var[0]] = array("temp" => $value["main"]["temp"], "min" => $value["main"]["temp_min"], "max"=> $value["main"]["temp_max"], "icone"=>$value["weather"][0]["icon"].".png", "data"=>$value['dt']) ;
               
           }else{               
               if($dias[$var[0]]["min"] > $value["main"]["temp_min"]){
                   $dias[$var[0]]["min"] = $value["main"]["temp_min"];                   
               }
               if($dias[$var[0]]["max"] < $value["main"]["temp_max"]){
                   $dias[$var[0]]["max"] = $value["main"]["temp_max"];
                   $dias[$var[0]]["icone"] = $value["weather"][0]["icon"].".png";
               }                              
           }                
       }
              
       //unset($dias[date('Y-m-d', $previsao_hoje["data"])]);
       return array_values(array_slice($dias, 0, 3));  
    }        

}
