<?php
namespace Division\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;

class DivisionModel{
    
    protected $dbadapter;
    
    public function __construct(Adapter $newAdapter){
        $this->dbadapter=$newAdapter;
    }
    
    public function get_Tramites($tramites="estado !='CANCELADO' AND estado !='POR INICIAR'"){
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
    
    public function holidays(){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Festivo')
            ->columns(array('fecha'));
        return $this->prepareStatement($statement, $db);
    }
    
    public function revokeTramite($nc, $motivo){
        $this->updateData('Tramite', array('estado'=>'CANCELADO', 'motivo'=>$motivo), array('Egresado_numControl'=>$nc, 'estado!="CANCELADO"'));
        $this->updateData('Egresado', array('status'=>'NUEVO'), array('numControl'=>$nc));
        $this->insertData('Mensajes', array('tipo'=>'ALERTA', 'contenido'=>'Tu trámite ha sido cancelado por: '.$motivo, 'para'=>$nc));;
        $this->deleteData("Citas", array("Egresado_numControl"=>$nc));
        return true;
    }
    

    public function get_juradoByEgresado($nc){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
        ->from('Jurado')
        ->join("Tramite", "Tramite.idTramite=Jurado.Tramite_idTramite")
        ->where(array("Egresado_numControl"=>$nc, "Tramite.estado!='CANCELADO'"));
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
    
    public function get_hours($day, $lugar){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Citas')
            ->where(array('fecha' => $day, 'lugar'=>$lugar))
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
    
    public function get_escolaresConfig(){
        $db = new Sql($this->dbadapter);
        $statement= $db->select();
        $statement
            ->from('Config')
            ->where(array('idConfig' => 2));
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
    
    public function set_DateConfig($f_inicio, $f_fin, $h_inicio, $h_fin, $intervalo){
        $data = array(
            'f_inicio'  => $f_inicio,
            'f_fin'     => $f_fin,
            'h_inicio'  => $h_inicio,
            'h_fin'     => $h_fin,
            'intervalo' => $intervalo
        );
        $this->updateData('Config', $data, array('idConfig'=>1));
        return true;
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
    
    public function getPlanesActivos(){
        $db = new Sql($this->dbadapter);
        $statement = new Select();
        $statement
            ->from('Plan')
            ->where(array('activo'=>1));
        return $this->prepareStatement($statement, $db);
    }
    
    public function agregarOpcion($data){
        $data["nombre"]=utf8_decode($data["nombre"]);
        $data["descripcion"]=utf8_decode($data["descripcion"]);
        $this->insertData("Opciones", $data);
        $id=$this->dbadapter->getDriver()->getLastGeneratedValue();
        $this->updateData("Opciones", array("imagen"=>"opcion".$id), array("idOpciones"=>$id));
        return $id;
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