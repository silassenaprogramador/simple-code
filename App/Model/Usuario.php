<?php

namespace Ssp\App\Model;

use Ssp\System\Model;

class Usuario extends Model
{

    protected $primary_key = "id";
    protected $fields = ["nome","email","senha"];
    protected $table = "usuario";

    public function __construct(){
       
       $this->db = self::connect();
    }
}