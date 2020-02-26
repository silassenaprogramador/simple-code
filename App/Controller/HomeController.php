<?php

namespace Ssp\App\Controller;

use Ssp\System\Controller;
use Ssp\App\Model\Usuario;

class HomeController extends Controller{

    
    /**
     * 
     */
    public function index(){
      
      $this->renderView('Public/index');
    }

    /**
     * 
     */
    public function exemplo(){


      $lista = Usuario::all();

      foreach($lista as $user){
        echo $user->nome . "<br>";
      }

	  	echo "exemplo";		
    }

    /**
     * 
     */
    public function exemplo2(){

		  echo $this->getUri(3);		
    }

}

