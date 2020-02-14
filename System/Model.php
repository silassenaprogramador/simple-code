<?php

namespace Ssp\System;


class Model extends Database
{

    protected $primary_key = "";
    protected $fields = [];
    protected $table = "";

    public function __construct(){
       
       $this->db = self::connect();
    }


    /**
     * 
     * 
     */
    public function save($dados){

        try{

            //limpando os dados do array para ficar somente com 
            //os valores correspondente na modelo e no banco de dados
            $dados_salvar = $this->fill($dados);
            
            $campos_insert = implode(",", $dados_salvar['keys']);
            $campos_valores = [];
            $paramentros = '';
            
            if(count($dados_salvar['values']) > 0){
                for($i = 0; $i < (count($dados_salvar['values'])) ; $i++ ){
                    $campos_valores[] = '?';     	
                }
                $paramentros = implode(',' , $campos_valores);
            }
            
            //PDO
            $query = "INSERT into " . $this->table . " ( " . $campos_insert . " ) values ( " . $paramentros . " ); ";

            echo $query;

            $stmt = $this->db->prepare($query);
            for ($k = 0; $k < count($campos_valores) ; $k++){
                $stmt->bindValue(($k + 1) , $dados_salvar['values'][$k] );
            }

            $result = $stmt->execute();

            return ['response' => true , 'message' => '', 'status' => 200 ];

        }catch(Exception $e){
            return ['response' => false , 'message' => $e->getMessage(), 'status' => 400 ];
        }   	

    }

    /** 
     * 
     * 
     */
   public function update($dados , $value_key = 0, $key = 'id'){

        try{
            
            $array_dados = $this->fill($dados);

            $array_fields_update = [];
            $fields_update = '';

            for($k=0; $k < count($array_dados['keys']) ;$k++){
                $array_fields_update[] = $array_dados['keys'][$k] . ' = ? ';  
            }
            $fields_update = implode(' , ' , $array_fields_update);

            //PDO
            $query = "UPDATE ".$this->table." set ". $fields_update ." WHERE ". $key ." = ? ";

            $stmt = $this->db->prepare($query);

            $total_campos_update = count($array_dados['values']);

            for ($i = 0; $i < $total_campos_update ; $i++){
                $stmt->bindValue(($i + 1) , $array_dados['values'][$i] );
            }

            $stmt->bindValue(($total_campos_update + 1) , $value_key );

            $result = $stmt->execute();

            return ['response' => true , 'message' => '', 'status' => 200 ];
            
        }catch(Exception $e){

            return ['response' => false , 'message' => $error[2], 'status' => 400 ];
        }

   }

    /**
     * 
     * 
     */
    public function getAll($array_where = null, $campos_params = null) {

        try{

            //
            $filtros = ' WHERE 1 = 1';
            if($array_where != null){
                $key_filtros = array_keys($array_where);
                for($i = 0; $i < count($array_where); $i++){
                    $filtros .= ' and '. $key_filtros[$i] .' = ?'; 
                }
            }
            
            if($campos_params != null){
                $campos_table = implode(' , ' , $campos_params);
            }else{
                $campos_table = implode(' , ' , $this->fields);
            }
           
    
            $query = "SELECT ".$campos_table." FROM " . $this->table . $filtros;
            
            $stmt = $this->db->prepare($query);

            if($array_where != null){
                $array_values = array_values($array_where);
                for ($k = 0; $k < count($array_where) ; $k++){
                    $stmt->bindValue(($k + 1) , $array_values[$k] );
                }
            }

            $stmt->execute();

            $lista = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $lista[] = $row;
            }

            if(count($lista) == 0){ 
                return ['response'=> [] , 'message'=>'registro nao encontrado', 'status' => 404];
            }
            
            return ['response'=> $lista , 'message'=>'', 'status' => 200];

        }catch(Exception $e){

            return ['response' => [] , 'message'=>$e->getMessage(), 'status' => 400];
        }

        
    }

     /**
     * 
     * 
     */
    public function getObject($array_where = null, $campos_params = null) {

        try{

            //
            $filtros = ' WHERE 1 = 1';
            if($array_where != null){
                $key_filtros = array_keys($array_where);
                for($i = 0; $i < count($array_where); $i++){
                    $filtros .= ' and '. $key_filtros[$i] .' = ?'; 
                }
            }
            
            if($campos_params != null){
                $campos_table = implode(' , ' , $campos_params);
            }else{
                $campos_table = implode(' , ' , $this->fields);
            }
           
    
            $query = "SELECT ".$campos_table." FROM " . $this->table . $filtros;
          
            
            $stmt = $this->db->prepare($query);

            if($array_where != null){
                $array_values = array_values($array_where);
                for ($k = 0; $k < count($array_where) ; $k++){
                    $stmt->bindValue(($k + 1) , $array_values[$k] );
                }
            }

            $stmt->execute();

            $lista = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $lista[] = $row;
            }

            if(count($lista) == 0){ 
                return ['response'=> [] , 'message'=>'registro nao encontrado', 'status' => 404];
            }
            
            return ['response'=> $lista[0] , 'message'=>'', 'status' => 200];

        }catch(Exception $e){

            return ['response' => [] , 'message'=>$e->getMessage(), 'status' => 400];
        }

        
    }

    /**
    *
    *
    */
    public function delete($id) {

        try{

            $stmt = $this->db->prepare("DELETE FROM ".$this->table." WHERE id = ?");
            $stmt->bindValue(1, $id);
    
            $result = $stmt->execute();

            return ['response'=> true , 'message'=>'', 'status' => 200];

        }catch(Exception $e){
            return ['response' => false , 'message'=>$e->getMessage(), 'status' => 400];
        }
    
    }


    /**
     * 
     * 
     */
    public function fill($dados)
    {

        $array_dados = [];

        foreach ($this->fields as $key) {
            if (array_key_exists($key, $dados)) {   
                $array_dados[$key] = $dados[$key] ;
            }
        }

        $array_keys = array_keys($array_dados);
        $array_values = array_values($array_dados);

        return ['dados'=>$array_dados , 'keys'=>$array_keys, 'values'=>$array_values];
        
    }
 
}