<?php

namespace Ssp\System;

class Controller 
{
    protected $params;
    private $viewPath;
    private $objRequest;

    public function __construct(){
        
        $this->params = new \stdClass;
        $this->objRequest = new \stdClass;
    }

    protected function renderView($viewPath, $dados = [] ){

        //converte o objeto em array
        if(is_object($dados)){
            $dados = json_decode($dados,true);     
        }

        //converte as chaves do array em variaveis 
        //para usar na view
        foreach($dados as $key => $value){
            $this->params->$key = $value;
        } 
        
        $this->viewPath = $viewPath;
        //abre a view dentro do controle
        $this->content();
    }

    private function content(){
        if(file_exists( __DIR__ . "/../{$this->viewPath}.php")){
            require_once ( __DIR__ . "/../{$this->viewPath}.php");
        }else{
          
            return 'Page Not Found';
        }
    }

    private function getLink($link){
        return BASE_URL . $link;
    }

    /** 
     * 
     */
    protected function getRequest(){
        
        $this->objRequest->post = $_POST;
        $this->objRequest->get = $_GET; 
        $this->objRequest->file = $_FILES;
        
        return $this->objRequest;
    }

     /** 
     * 
     */
    protected function requestPost(){
        
        $this->objRequest->post = $_POST;
        return $this->objRequest->post;
    }

    public function getUri($index){

        $url = parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH);
        $lista = explode( '/',$url);
        return $lista[$index];
    }
       
} 
