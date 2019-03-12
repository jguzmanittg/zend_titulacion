<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Academia for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Academia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Academia\Model\AcademiaModel;
use Zend\View\Model\JsonModel;
use function Zend\Mvc\Controller\redirect;
use Zend\Session\Container;
date_default_timezone_set('America/Mexico_City');
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $user = new Container('Academia');
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return new ViewModel(array("tramites"=>$academia->get_Tramites(
            " estado='SOLICITUD ASESORES' OR 
              estado='ASESORES ASIGNADOS' OR
              estado='SOLICITUD JURADO' OR
              estado='JURADO ASIGNADO' OR
              estado='ASESORIA LIBERADA' AND carrera='".$user->carrera."'"), "holidays"=>$academia->holidays(), "config"=>$academia->get_config()));
    }
    
    public function testAction(){
        $user = new Container('Academia');
        return $this->response(array("test"=>$user->carrera));
    }
    
    public function getEgresadoInfoAction(){
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("info"=>$academia->get_TramiteEgresado($this->getRequest()->getPost('egresado')),
            "requisitos"=>$academia->get_requisitosEgresado($this->getRequest()->getPost('egresado')),
            "docs"=>$academia->get_DocsUploadedByEgresado($this->getRequest()->getPost('egresado')),
            "jurado"=>$academia->get_juradoByEgresado($this->getRequest()->getPost('egresado')),
            "juradoT"=>$academia->get_juradoTitulacionByEgresado($this->getRequest()->getPost('egresado'))
        ));
    }

    public function cerrarAction(){
        $user = new Container('Academia');
        $user->getManager()->getStorage()->clear('Academia');
        return $this->redirect()->toUrl('../');
    }
    
    public function asignarAsesoresAction(){
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $academia->setAsesores($this->getRequest()->getPost());
        return $this->redirect()->toUrl("../academia");
    }
    
    public function asignarJuradoAction(){
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $academia->setJurado($this->getRequest()->getPost());
        return $this->redirect()->toUrl("../academia");
    }
    

    public function nuevoEstadoTramiteAction(){
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("response"=>$academia->updateStatusTramite(
            $this->getRequest()->getPost("nc"),
            $this->getRequest()->getPost("estado"))));
    }    
    
    public function lookForAsesoresByNumAction(){
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array(
            "jurado"=>$academia->getAsesorByNt($this->getRequest()->getPost('nt'))));        
    }
    
    public function liberarAsesoriaAction(){
        $academia = new AcademiaModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $archivos = $this->getRequest()->getFiles()->toArray();
        $nc=$this->getRequest()->getPost('nc');
        $error=false;
        $code="OK";
        $validator = new \Zend\Validator\File\Extension('pdf, png, jpg, jpeg');
        foreach ($archivos as $key=>$file):
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
        move_uploaded_file($file['tmp_name'], 'public/uploads/liberaciones/'.'AL'.$nc);
        endforeach;
        if($code=="OK"){
             return $this->response(array("code"=>$code, "response"=>$academia->updateStatusTramite(
                $nc, $this->getRequest()->getPost("estado"))));
        }
        return $this->response(array("code"=> $code, "error"=> $error));
    }

    private function response($array){
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                $array
                ));
        return $response->getContent();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }
}
