<?php
namespace Documentos\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;

class DocumentosModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function get_EgresadoInfo($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from(array('t1'=>'Egresado'))
            ->columns(array(
                'numcontrol', 
                'nombre',
                'apellidos',
                'nombreComp',
                'deudor',
                'planEstudios',
                'status',
                'correo'))
            ->where("t1.numcontrol ='".$nc."'");
        return $this->prepareStatement($statement, $db)[0];
    }
    
    public function get_TramiteEgresado($egresado){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Tramite')
        ->where("estado != 'CANCELADO' AND Tramite.Egresado_Numcontrol ='".$egresado."'")
        ->join("Citas", "Tramite.Egresado_numControl = Citas.Egresado_numControl")
        ->join("Egresado", "Egresado.numControl = Tramite.Egresado_numControl")
        ->join("Opciones", "Tramite.opcion = Opciones.idOpciones");
        return $this->prepareStatement($statement, $db)[0];
    }
    

    public function get_JuradoDelEgresado($nc){
        $tipo ="JURADO";
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Jurado')
        ->join("Tramite", "Tramite.idTramite=Jurado.Tramite_idTramite")
        ->join("Sinodales", "Jurado.numTarjeta=Sinodales.numTarjeta")
        ->where(array("Tramite.Egresado_numControl"=>$nc, "Tramite.estado!='CANCELADO'", "Jurado.tipo='".$tipo."'"));
        return $this->prepareStatement($statement, $db);
    }
    public function get_AsesoresYJuradoDelEgresado($nc, $tipo){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Jurado')
        ->join("Tramite", "Tramite.idTramite=Jurado.Tramite_idTramite")
        ->where(array("Tramite.Egresado_numControl"=>$nc, "Tramite.estado!='CANCELADO'", "Jurado.tipo='".$tipo."'"));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_DocsUploadedByEgresado($egresado){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Tramite')
            ->join("Requisitos", "Requisitos.Opciones_idOpciones=Tramite.opcion")
            ->where(array("Egresado_numControl"=>$egresado, "tipo='archivo'", "Tramite.estado!='CANCELADO'"));
        return $this->prepareStatement($statement, $db);
    }

    public function get_InformacionProporcionadaPorEgresado($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Valores')
            ->join("Requisitos", "Valores.Requisitos_idRequisitos=Requisitos.idRequisitos")
            ->where(array('Valores.Egresado_numControl' => $nc));
        return $this->prepareStatement($statement, $db);   
    }

    public function get_JefeDeAcademia($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Egresado')
            ->join("Puesto", "Egresado.carrera=Puesto.area")
            ->where(array("Egresado.numControl"=>$nc, "Puesto.puesto='JEFE DE ACADEMIA'", "Puesto.status='ACTIVO'"));
        return $this->prepareStatement($statement, $db)[0];   

    }

    public function get_OpcionProtocolaria($opcion){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();  
        $statement
            ->from('Opciones')
            ->where(array("Opciones.idOpciones" => $opcion ));
        return $this->prepareStatement($statement, $db);   

    }

    public function get_ResponsableDelPuesto($puesto){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Puesto')
            ->where(array("Puesto.puesto='".$puesto."'", "Puesto.status='ACTIVO'"));
        return $this->prepareStatement($statement, $db)[0];   
    }

    public function get_citaEscolaresHora($citas){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Citas')
            ->where(array("Egresado_numControl"=>$egresado,"Citas.lugar='ESCOLARES'"));
        return $this->prepareStatement($statement, $db)[0];   
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