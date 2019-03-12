<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Egresado for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Egresado\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Egresado\Model\EgresadoModel;
use Zend\View\Model\JsonModel;
use function Zend\Mvc\Controller\redirect;
use Zend\Session\Container;
use DOMPDFModule\View\Model\PdfModel;

date_default_timezone_set('America/Mexico_City');

class IndexController extends AbstractActionController
{



    public function indexAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $egresado->get_StatusTramite();
        $config = $egresado->get_config();
        $user = new Container('nc');
        $show = false;
        $status_calendario=array('CITA AGENDADA', 'REAGENDAR');
        if (in_array($user->status, $status_calendario))$show=true;
        return new ViewModel(
            array(
                'opciones'  => $egresado->get_opciones($user->plan, $user->usercontrol),
                'calendar'  => $show,
                'status'    => $user->status, 
                'holidays'  => $egresado->holidays(), 
                'config'    => $config[0], 
                'cita'      => $egresado->get_cita($user->usercontrol),
                'username'  => $user->username,
                'usercontrol'=> $user->usercontrol));
    }
    

    public function estadoAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $egresado->get_StatusTramite();
        $config = $egresado->get_config();
        $user = new Container('nc');
        $show = false;
        $status_calendario=array('CITA AGENDADA', 'REAGENDAR');
        if (in_array($user->status, $status_calendario))$show=true;
        return new ViewModel(
            array(
                'opciones'  => $egresado->get_opciones($user->plan, $user->usercontrol),
                'calendar'  => $show,
                'status'    => $user->status, 
                'holidays'  => $egresado->holidays(), 
                'config'    => $config[0], 
                'cita'      => $egresado->get_cita($user->usercontrol),
                'username'  => $user->username,
                'usercontrol'=> $user->usercontrol));
    }
    
    public function getHoursAction(){
        $day = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('dia')))));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
            array(
                'horas'     => $egresado->get_hours($day, $this->getRequest()->getPost('lugar')),
                'cfg'    => $egresado->get_config()
            )
        ));
        return $response->getContent();
    }
    
    public function checkCitaAction(){
        $date = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('datepicker')))));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $response = $this->getResponse();
        $user = new Container('nc');
        if ($this->getRequest()->getPost('mode')=="update")
            $content =
            new JsonModel(
                array (
                    'agendado' => $egresado->agendarCita(urldecode($this->getRequest()->getPost('hour')),
                        $date,
                        $user->usercontrol,
                        $this->getRequest()->getPost('lugar'),
                        true)
                )
                );
        else
            $content =
            new JsonModel(
                array (
                    'agendado' => $egresado->agendarCita(urldecode($this->getRequest()->getPost('hour')),
                        $date,
                        $user->usercontrol,
                        $this->getRequest()->getPost('lugar'))
                )
                );
        $response->setContent($content);
        return $response->getContent();
    }
    
    public function getRequisitosAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                array (
                    'requisitos' => $egresado->get_requisitos($this->getRequest()->getPost('idOpcion'))
                )
                ));
        return $response->getContent();
        
    }
    /*
     $egresado->reagendarCita($this->getRequest()->getPost('hour'),
                                                            $date,
                                                            $user->usercontrol)   */
    
    /*public function getCfgHoursAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                array (
                    'cfg' => $egresado->get_cfgHours()
                )
                ));
        return $response->getContent();        
    }*/
    
    public function getOpcionInfoAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                array (
                    'info' => $egresado->get_opcionInfo($this->getRequest()->getPost('idOpcion')),
                    'requisitos' => $egresado->get_requisitos($this->getRequest()->getPost('idOpcion'))
                )
            ));
        return $response->getContent();
    }
    
    public function checkDatosAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $user = new Container('nc');
        $archivos = $this->getRequest()->getFiles()->toArray();
        $error=false;
        $code="OK";
        $validator = new \Zend\Validator\File\Extension('pdf, png, jpg, jpeg');
        foreach ($archivos as $key => $file):
            if ($file['size']>2000000 || $file['size']==0){
                $error=$file['name'];
                $code=utf8_encode("Error: Archivo demasiado grande, los archivos deben pesar menos de 2 Mb.");
                break;
            }
            if (!$validator->isValid($file)){
                $error=$file['name'];
                $code=utf8_encode("Error: Formato inválido, el sistema sólo admite PDF, PNG, JPG o JPEG.");
                break;
            }                
            move_uploaded_file($file['tmp_name'], 'public/uploads/'.$key.$user->usercontrol);
        endforeach;
        if($code=="OK"){
            $valores = $this->getRequest()->getPost()->toArray();
            $valores["usuario"] = $user->usercontrol;
            $egresado->save_Requisitos(
                array_slice($valores, 0, sizeof($valores)-2, $preserve_keys = true),
                array_slice($valores, sizeof($valores)-2, 2, $preserve_keys = true));
        }
        return $this->response(array("code"=> $code, "error"=> $error));
    }    
    
    public function contactoAction(){
        return new ViewModel();
    }
    
    public function cerrarAction(){
        $user = new Container('nc');
        $user->getManager()->getStorage()->clear('nc');
        return $this->redirect()->toUrl('../');
    }
    
    public function pdfAction(){
        $pdf = new PdfModel();
        $pdf->setVariables($this->getInfoForDocument());
        return $pdf;
        return new ViewModel();
    }
    /*
     * public function get_AllEgresadoData($nc){
        $db = new Sql($this->dbadapter);
        $statement = new Select();
        $statement
            ->from(array('t1'=>'Egresado'))
            ->join(array('t2'=>'Tramite'), "t2.Egresado_numControl=t1.numControl", array('*'), "left")
            ->where(array("t1.numControl" => $nc));
        return $this->prepareStatement($statement, $db);
    }
     */
    public function getInfoForDocument(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $egresado = new EgresadoModel($dbAdapter);
        $user = new Container('nc');
        $data=$egresado->get_AllEgresadoData($user->nc);
        return array(
            'nombreAlum' => 'John Doe Perez Juan',
            'opcion'=> 'MemoResPro',  //doc1
            'dia'=> '3',
            'mes'=> 'Febrero',
            'aÃ±o'=> '2007',
            'carreraAlum' =>'ING. EN SISTEMAS COMPUTACIONALES',
            'temaAlum'=> 'Rendimiento de cultimos organicos mediante el riego automatizado de equips portatiles',
            'numControl'=> '11270798',
            'opcionSelec'=> 'TITULACION INTEGRADA',
            'director' =>'JOSE LUIS MENDEZ NAVARRO',
            'jefeDivision'=> 'JUAN JOSE ARREOLA ORDAZ',
            'coordinadorDiv'=> 'ELIN ENRIQUE AGUILAR MORENO',
            'jefeEscolares'=> 'SALOMON VELASCO BERMUDEZ',
            'direccionAlum'=> 'MI DIRECCION ENTRE NOSE Y CALLE ALTA #3',
            'teleAlum'=> '9611232312',
            'emailAlum' =>'Juan@hotmail.com',
            'hora' =>'23:00',
            'salon' =>'E1',
            'presidente'=> 'RAFAEL MOTA VELAZQUES ',
            'secretario' =>'ARIOSTO MANDUJANO CERVANTES ',
            'vocal' =>'KARLOS VELASQUEZ MORENO',
            'presidenteCarrera' =>'INGENIERO EN CIENCIAS DE INGENIERIA ',
            'secretarioCarrera' =>' INDUSTRIAL ELECTRICISTA',
            'vocalCarrera'=> 'IGENIERO INDUSTRIAL EN ELECTRICA',
            'presidenteCedula'=> '2499051',
            'secretarioCedula'=> '3454977',
            'vocalCedula' =>'7698092',
            'aprobado' =>'ACEPTADO(A)',
            'departamento'=> 'INGENIERIA EN SISTEMAS COMPUTACIONALES',
            'jefeAcademia' =>'MARIA GUADALUPE MONJARAS VELASCO',
            'nombreAsesor' =>'FRANSISCO GUZMAN PEDRERO',
            'nombreAsesor2' =>'CARMELITA ACOSTA SALINAS',
            'vocalSuplente'=> 'PEDRITO FERNANDEZ RUIZ',
            'vocalSCarrera'=> 'INGENIERO EN MECANICA',
            'vocalSCedula' =>'4567896',
            'jefeDepartamento'=> 'MARIA GUADALUPE MONJARAS VELASCO',
            'revisor'=>'PANCHITO PEREZ PEREZ',
            'revisor2'=> 'JUANITA MARIA GUTIERREZ',
            'numReg' =>'1239',
            'nivel'=> 'LICENCIATURA',
        );
    }
    
    private function response($array){
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                $array
                ));
        return $response->getContent();
    }
    
}
