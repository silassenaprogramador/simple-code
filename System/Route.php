<?php

namespace Ssp\System;

class Route{

    private $routes;
    
    public function __construct(array $routes){
        
        $this->routes = $routes;
        $this->run();
     }
    
     /**
      * Retorna a URL digita no navegador
      */
    private function getUrl(){
        $url_atual = "http" . (isset($_SERVER['HTTPS']) ? (($_SERVER['HTTPS']=="on") ? "s" : "") : "") . "://" . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $url_atual;
    }


    /**
     * Constroi a rota e redireciona para classe
     */
    private function run(){

        $access_route = $this->getUrl();
        $found = false;
        $params = array();

        //vai pegar todas as rotas registradas no arquivos routes e compara uma por uma
        //com a rota informada no arquivo
        foreach($this->routes as $item_route){

            $rota_informada = explode('/',  $access_route );
            $rota_registrada = explode('/', BASE_URL.$item_route[0]);
            
            //vai entrar aqui quando o tamanho informada for igual ao tamanho 
            //da rota que esta sendo analisada.

            if(count($rota_informada) == count($rota_registrada)) {

                for($i=0; $i<count($rota_registrada);$i++){
                    
                    //substituí os paramentos da rota registrada, pelos paramentros 
                    //da rota informada, para verificar se as urls corresponde.
                    if(   (strpos($rota_registrada[$i], "{") !== false)){
                        $rota_registrada[$i] = $rota_informada[$i];
                        $params[] = $rota_informada[$i];
                    }
                }           
                
                $str_rota_registrada = implode('/',$rota_registrada);
                if($access_route == $str_rota_registrada){

                    $found = true;
                    $name_controller = $item_route[1];
                    $action = $item_route[2];
                    break;
                }
                
            }
            
        }

        if($found){

            $objController = new $name_controller;
            $objController->$action(implode(',',$params));

        }else{
            require_once ( __DIR__ . "/Errors/404.php");
        }


    }
}
