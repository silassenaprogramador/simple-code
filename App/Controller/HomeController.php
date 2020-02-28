<?php

namespace Ssp\App\Controller;

use Ssp\System\Controller;


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

	  	echo "exemplo";		
    }

    /**
     * 
     */
    public function exemplo2(){

		  echo $this->getUri(3);		
    }

}

