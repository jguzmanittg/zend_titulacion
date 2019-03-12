<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class ConfigModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function get_config(){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Config')
        ->columns(array('api'));
        return $this->prepareStatement($statement, $db);
    }
    
    public function prepareStatement($statement, $db){
        $resultSet = new ResultSet();
        $query=$db->prepareStatementForSqlObject($statement);
        $resultSet->initialize($query->execute());
        return $resultSet->toArray();
    }
    
    
}