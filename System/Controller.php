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

        foreach($dados as $key => $value){
            $this->params->$key = $value;
        } 
        
        $this->viewPath = $viewPath;
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

    public function getUri($index){

        $url = parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH);
        $lista = explode( '/',$url);
        return $lista[$index];
    }
       
} 