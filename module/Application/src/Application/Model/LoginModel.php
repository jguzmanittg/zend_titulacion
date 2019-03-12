<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class LoginModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function egresado($nc, $password){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Egresado')
            ->where(array('numControl' => $nc, 'password' => $password));
        return $this->prepareStatement($statement, $db);
    }
    
    public function existeEgresado($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Egresado')
            ->where(array('numControl' => $nc));
        return $this->prepareStatement($statement, $db);
        
    }
    
    public function academia($user, $pass){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Academia')
        ->where(array('academia' => $user, 'password' => $pass));
        return $this->prepareStatement($statement, $db);
    }
    
    public function division($user, $pass){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Academia')
        ->where(array('academia' => $user, 'password' => $pass, 'carrera'=>'DIVISION'));
        return $this->prepareStatement($statement, $db);
    }
    
    public function escolares($user, $pass){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Academia')
            ->where(array('academia' => $user, 'password' => $pass, 'carrera'=>'ESCOLARES'));
        return $this->prepareStatement($statement, $db);
        return true;
    }
    
    public function juntas(){
        return true;
    }
    
    public function prepareStatement($statement, $db){
        $resultSet = new ResultSet();
        $query=$db->prepareStatementForSqlObject($statement);
        $resultSet->initialize($query->execute());
        return $resultSet->toArray();
    }
}