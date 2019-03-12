<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class AddModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function addEgresado($data){
        $db = new Sql($this->dbadapter);
        $statement = $db->insert();
        $statement
            ->into('Egresado')
            ->values($data);
        $query=$db->prepareStatementForSqlObject($statement);
        $query->execute();
    }
    
    public function get_Planes(){
        return $this->selectData("Plan", array("activo" => 1));
    }
    
    public function get_Licenciaturas(){
        return $this->selectData("Carrera");
    }
    
    public function prepareStatement($statement, $db){
        $resultSet = new ResultSet();
        $query=$db->prepareStatementForSqlObject($statement);
        $resultSet->initialize($query->execute());
        $array = $resultSet->toArray();
        foreach ($array as &$item):
            foreach ($item as &$key):
                $key = utf8_encode($key);
            endforeach;
        endforeach;
        return $array;
    }
    
    public function selectData($tabla, $condicion = true){
        $db = new Sql($this->dbadapter);
        $statement = new Select();
        $statement->from($tabla);
        $statement->where($condicion);
        return $this->prepareStatement($statement, $db);
    }
    
}