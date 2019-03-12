<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Division for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Division\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Division\Model\DivisionModel;
use Zend\View\Model\JsonModel;
use function Zend\Mvc\Controller\redirect;
use Zend\Session\Container;
date_default_timezone_set('America/Mexico_City');
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $division = new DivisionModel($dbAdapter);
        return new ViewModel(array(
            "tramites"=>$division->get_Tramites(), 
            "holidays"=>$division->holidays(), 
            "config"=>$division->get_config(),
            "cfgE"=>$division->get_escolaresConfig()
        ));
    }
    
    public function configuracionAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $division = new DivisionModel($dbAdapter);
        return new ViewModel(array("config" => $division->get_config(), "holidays" => $division->holidays(), 
            "planes" => $division->getPlanesActivos()));
    }
    
    public function updateDatesAction(){
        $f_inicio = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('f_inicio')))));
        $f_fin = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('f_fin')))));
        $h_inicio=urldecode($this->getRequest()->getPost('h_inicio'));
        $h_fin=urldecode($this->getRequest()->getPost('h_fin'));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $division = new DivisionModel($dbAdapter);
        $division->set_DateConfig($f_inicio, $f_fin, $h_inicio, $h_fin, $this->getRequest()->getPost('intervalo'));
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                array('code' => 1)
                ));
        return $response->getContent();
    }
    
    public function revokeTramiteAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $division->revokeTramite($this->getRequest()->getPost('nc'), $this->getRequest()->getPost('motivo'));
        return $this->response(array("revoke"==true));
    }

    public function fooAction(){
        return array();
    }
    
    public function cerrarAction(){
        $user = new Container('Division');
        $user->getManager()->getStorage()->clear('Division');
        return $this->redirect()->toUrl('../');
    }
    
    public function checkCitaAction(){
        $date = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('datepicker')))));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $division= new DivisionModel($dbAdapter);
        $response = $this->getResponse();
        if ($this->getRequest()->getPost('mode')=="update")
            $content =
            new JsonModel(
                array (
                    'agendado' => $division->agendarCita(urldecode($this->getRequest()->getPost('hour')),
                        $date,
                        $this->getRequest()->getPost('nc'),
                        $this->getRequest()->getPost('lugar'),
                        true)
                )
                );
            else
                $content =
                new JsonModel(
                    array (
                        'agendado' => $division->agendarCita(urldecode($this->getRequest()->getPost('hour')),
                            $date,
                            $this->getRequest()->getPost('nc'),
                            $this->getRequest()->getPost('lugar'))
                    )
                    );
                $response->setContent($content);
                return $response->getContent();
    }
    
    public function getEgresadoInfoAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("info"=>$division->get_TramiteEgresado($this->getRequest()->getPost('egresado')),
            "requisitos"=>$division->get_requisitosEgresado($this->getRequest()->getPost('egresado')),
            "docs"=>$division->get_DocsUploadedByEgresado($this->getRequest()->getPost('egresado')),
            "jurado"=>$division->get_juradoByEgresado($this->getRequest()->getPost('egresado')),
            "juradoT"=>$division->get_juradoTitulacionByEgresado($this->getRequest()->getPost('egresado'))
        ));
    }
    
    public function getRequisitosByOptionAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("requisitos"=>$division->get_requisitos($this->getRequest()->getPost('id'))));
    }
    
    public function getHoursAction(){
        $day = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('dia')))));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $division = new DivisionModel($dbAdapter);
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                array(
                    'horas'     => $division->get_hours($day, $this->getRequest()->getPost('lugar')),
                    'cfg'    => $division->get_config()
                )
                ));
        return $response->getContent();
    }
    
    public function revisionEscolaresAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $division->updateStatusTramite(
            $this->getRequest()->getPost("nc"),
            $this->getRequest()->getPost("estado"));
        return $this->redirect()->toUrl('../division');
    }
    
    public function updateStatusAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $division->updateStatusTramite(
            $this->getRequest()->getPost("nc"),
            $this->getRequest()->getPost("estado"));
        return $this->redirect()->toUrl('../division');
    }
    
    public function nuevoEstadoTramiteAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("response"=>$division->updateStatusTramite(
            $this->getRequest()->getPost("nc"),
            $this->getRequest()->getPost("estado"))));
    }
    
    public function agregarOpcionAction(){
        $division = new DivisionModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $id=$division->agregarOpcion($this->getRequest()->getPost()->toArray());
        $file = $this->getRequest()->getFiles()->toArray();
        $file=$file["imagen"];
        move_uploaded_file($file['tmp_name'], 'public/img/opcion'.$id);
        return $this->redirect()->toUrl('../division/configuracion');
        
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
