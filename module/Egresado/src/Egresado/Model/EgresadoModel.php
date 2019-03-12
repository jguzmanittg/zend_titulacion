<?php
namespace Egresado\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Session\Container;

class EgresadoModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function holidays(){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Festivo')
            ->columns(array('fecha'));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_hours($day, $lugar){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Citas')
            ->where(array('fecha' => $day, 'lugar' => $lugar))
            ->columns(array('hora'));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_config(){
        $db = new Sql($this->dbadapter);        
        $statement= $db->select();
        $statement
            ->from('Config')
            ->where(array('idConfig' => 1));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_opciones($plan, $nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Opciones')
            ->where("idOpciones NOT IN (
                    SELECT  Tramite.opcion 
                    FROM Tramite 
                    WHERE Egresado_numControl=".$nc." AND motivo='INCUMPLIMIENTO'
                    ) AND plan=".$plan);
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_opcionInfo($idOpcion){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Opciones')
            ->where(array('idOpciones'=>$idOpcion));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_requisitos($idOpcion){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Requisitos')
        ->where(array('Opciones_idOpciones'=>$idOpcion));
        return $this->prepareStatement($statement, $db);
    }
    
    public function agendarCita($hour, $date, $user, $lugar, $update = false){
        $data = array(
            'fecha'                 => $date,
            'hora'                  => $hour,
            'lugar'                 => $lugar
        );
        $this->dbadapter->query("LOCK TABLE Citas WRITE");
        if (count($this->selectData("Citas", $data))==0){
            if ($update)
                $this->updateData("Citas", $data, array("Egresado_numControl" => $user));    
            else{
                $data["Egresado_numControl"] = $user;
                $this->insertData("Citas", $data);
            }
            $this->dbadapter->query("UNLOCK TABLES");
            $this->updateData("Egresado", array("status"=>"EN TRAMITE"), array("numControl"=>$user));   
            $this->updateData("Tramite", array("estado"=>"CITA AGENDADA"), array("Egresado_numControl"=>$user, "estado" => "POR INICIAR"));
            return true;            
        }

        $this->dbadapter->query("UNLOCK TABLES");
        return false;
    }
    
    public function save_Requisitos($requisitos, $extras){   
        $this->deleteData("Tramite", array("Egresado_numControl"=>$extras["usuario"], "estado != 'CANCELADO'"));
        $this->deleteData("Valores", array("Egresado_numControl"=>$extras["usuario"]));
        $data = array(
            'opcion'                => $extras["opcion_hidden"],
            'Egresado_numControl'   => $extras["usuario"],
            'estado'                => "POR INICIAR"
        );
        $this->insertData("Tramite", $data);
        
        foreach ($requisitos as $key => $item):
            $data = array(
                'Requisitos_idRequisitos'   => $key,
                'Egresado_numControl'       => $extras["usuario"],
                'datos'                     => $item                
            );
            $this->insertData("Valores", $data);
        endforeach;
        return true;
    }
    
    public function get_Status(){
        $user = new Container('nc');
        $condicion = array(
            'numControl' => $user->usercontrol    
        );
        $status = $this->selectData('Egresado', $condicion);
        $user->status = $status[0]['status'];
        return true;
    }
    
    public function get_StatusTramite(){
        $user = new Container('nc');
        $condicion = array(
            'Egresado_numControl' => $user->usercontrol,
            'estado != "CANCELADO"',
            'estado != "POR INICIAR"'
        );
        $status = $this->selectData('Tramite', $condicion);
        if (sizeof($status)>0)
            $user->status = $status[0]['estado'];
        else $user->status = "NUEVO";
        return true;
    }
    
    public function get_cita($nc){
        $db = new Sql($this->dbadapter);
        $statement = new Select();
        $statement->from("Citas");
        $statement->where(array("Egresado_numControl" => $nc));
        return $this->prepareStatement($statement, $db);
    }
    
    public function reagendarCita($hora, $fecha, $nc){
        $this->updateData("Citas", array("fecha"=>$fecha, "hora" => $hora), array("Egresado_numControl" => $nc));
        return true;
    }
    
    public function get_cfgHours(){
        $db = new Sql($this->dbadapter);
        $statement = new Select();
        $statement->from("Config");
        return $this->prepareStatement($statement, $db);
    }

    public function selectData($tabla, $condicion = true){
        $db = new Sql($this->dbadapter);
        $statement = new Select();
        $statement->from($tabla);
        $statement->where($condicion);
        return $this->prepareStatement($statement, $db);
    }
    
    public function insertData($tabla, $data){
        $db = new Sql($this->dbadapter);
        $statement = $db->insert($tabla);
        $statement->values($data);
        $query=$db->prepareStatementForSqlObject($statement);
        $query->execute();
    }
    
    public function updateData($tabla, $data, $condicion){
        $db = new Sql($this->dbadapter);
        $statement = $db->update($tabla);
        $statement
            ->set($data)
            ->where($condicion);
        $query=$db->prepareStatementForSqlObject($statement);
        $query->execute();
    }
    
    public function deleteData($tabla, $condicion){
        $db = new Sql($this->dbadapter);
        $statement = $db->delete($tabla);
        $statement
            ->where($condicion);
        $query=$db->prepareStatementForSqlObject($statement);
        $query->execute();
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
    
}