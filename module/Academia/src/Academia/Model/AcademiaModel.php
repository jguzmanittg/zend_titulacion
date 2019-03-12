<?php
namespace Academia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;

class AcademiaModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function get_Tramites($tramites){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Tramite')
            ->where($tramites)
            ->join("Citas", "Tramite.Egresado_numControl = Citas.Egresado_numControl")
            ->join("Egresado", "Egresado.numControl = Tramite.Egresado_numControl")
            ->join("Opciones", "Tramite.opcion = Opciones.idOpciones");
        return $this->prepareStatement($statement, $db);
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
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_RequisitosEgresado($egresado){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Valores')
            ->join("Requisitos", "Requisitos.idRequisitos=Valores.Requisitos_idRequisitos")
            ->where(array("Egresado_numControl"=>$egresado, "tipo!='archivo'"));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_juradoByEgresado($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Jurado')
            ->join("Tramite", "Tramite.idTramite=Jurado.Tramite_idTramite")
            ->where(array("Egresado_numControl"=>$nc, "Tramite.estado!='CANCELADO'", "Jurado.tipo='ASESOR'"));
        return $this->prepareStatement($statement, $db);
    }
    
    public function get_juradoTitulacionByEgresado($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Jurado')
        ->join("Tramite", "Tramite.idTramite=Jurado.Tramite_idTramite")
        ->where(array("Egresado_numControl"=>$nc, "Tramite.estado!='CANCELADO'", "Jurado.tipo='JURADO'"));
        return $this->prepareStatement($statement, $db);
    }
    
    public function getAsesorByNt($nt){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Sinodales')
            ->where(array("numTarjeta"=>$nt));
        return $this->prepareStatement($statement, $db);
    }
    
    public function holidays(){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Festivo')
            ->columns(array('fecha'));
        return $this->prepareStatement($statement, $db);
    }
     
    public function get_hours($day){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Citas')
            ->where(array('fecha' => $day))
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
    
    public function get_opciones($plan){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Opciones')
            ->where(array('plan' => $plan));
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
    
    public function get_DocsUploadedByEgresado($egresado){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Tramite')
            ->join("Requisitos", "Requisitos.Opciones_idOpciones=Tramite.opcion")
            ->where(array("Egresado_numControl"=>$egresado, "tipo='archivo'", "Tramite.estado!='CANCELADO'"));
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
                return true;
        }    
        $this->dbadapter->query("UNLOCK TABLES");
        return false;
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
    
    public function updateStatusTramite($nc, $nuevoEstado){
        $this->updateData("Tramite", array("estado"=>$nuevoEstado), array("Egresado_numControl" => $nc, "estado!='CANCELADO'"));
        return true;
    }
    
    public function setAsesores($datos){
        $tramite=$this->get_TramiteEgresado($datos["nc"]);
        $tramite=$tramite[0]["idTramite"];
        $data=array(
            "j1"=>array("nombre"=>$datos["asesor1"], "numTarjeta"=>$datos["id1"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"ASESOR"),
            "j2"=>array("nombre"=>$datos["asesor2"], "numTarjeta"=>$datos["id2"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"ASESOR"),
            "j3"=>array("nombre"=>$datos["asesor3"], "numTarjeta"=>$datos["id3"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"ASESOR"),
        );
        foreach ($data as $asesor):
            $this->insertData("Jurado", $asesor);
        endforeach;
        $this->updateStatusTramite($datos["nc"], $datos["estado"]);
        return true;
    }
    
    public function setJurado($datos){
        $tramite=$this->get_TramiteEgresado($datos["nc"]);
        $tramite=$tramite[0]["idTramite"];
        $data=array(
            "j1"=>array("nombre"=>$datos["asesor1"], "numTarjeta"=>$datos["id1"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"JURADO"),
            "j2"=>array("nombre"=>$datos["asesor2"], "numTarjeta"=>$datos["id2"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"JURADO"),
            "j3"=>array("nombre"=>$datos["asesor3"], "numTarjeta"=>$datos["id3"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"JURADO"),
            "j4"=>array("nombre"=>$datos["asesor4"], "numTarjeta"=>$datos["id4"], "Tramite_idTramite"=>$tramite, "status"=>"ASIGNADO", "tipo"=>"JURADO"),
        );
        foreach ($data as $asesor):
        $this->insertData("Jurado", $asesor);
        endforeach;
        $this->updateStatusTramite($datos["nc"], $datos["estado"]);
        return true;
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