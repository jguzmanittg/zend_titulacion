<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Escolares for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Escolares\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Escolares\Model\EscolaresModel;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use function Zend\Mvc\Controller\redirect;
use Zend\Session\Container;
date_default_timezone_set('America/Mexico_City');
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $escolares = new EscolaresModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return new ViewModel(array("tramites"=>$escolares->get_Tramites(
            "(estado='DOCUMENTOS REVISADOS' OR 
                estado='ACTO AGENDADO' OR 
                estado='NO INCONVENIENCIA' OR 
                estado='REVISION ESCOLARES'OR
                estado='TRAMITE FINALIZADO')"), 
                "holidays"=>$escolares->holidays(), 
                "cfgE"=>$escolares->get_escolaresConfig()));
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }
    
    public function nuevoEstadoTramiteAction(){
        $escolares = new EscolaresModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("response"=>$escolares->updateStatusTramite(
            $this->getRequest()->getPost("nc"),
            $this->getRequest()->getPost("estado"))));
    }
    
    public function getEgresadoInfoAction(){
        $escolares = new EscolaresModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        return $this->response(array("info"=>$escolares->get_TramiteEgresado($this->getRequest()->getPost('egresado')),
            "requisitos"=>$escolares->get_requisitosEgresado($this->getRequest()->getPost('egresado')),
            "docs"=>$escolares->get_DocsUploadedByEgresado($this->getRequest()->getPost('egresado')),
            "jurado"=>$escolares->get_juradoByEgresado($this->getRequest()->getPost('egresado'))
        ));
    }
    
    private function response($array){
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                $array
                ));
        return $response->getContent();
    }
    
    public function cerrarAction(){
        $user = new Container('Escolares');
        $user->getManager()->getStorage()->clear('Division');
        return $this->redirect()->toUrl('../');
    }
    
    public function checkCitaAction(){
        $date = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('datepicker')))));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $escolares= new EscolaresModel($dbAdapter);
        $response = $this->getResponse();
        if ($this->getRequest()->getPost('mode')=="update")
            $content =
            new JsonModel(
                array (
                    'agendado' => $escolares->agendarCita(urldecode($this->getRequest()->getPost('hour')),
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
                        'agendado' => $escolares->agendarCita(urldecode($this->getRequest()->getPost('hour')),
                            $date,
                            $this->getRequest()->getPost('nc'),
                            $this->getRequest()->getPost('lugar'))
                    )
                    );
                $response->setContent($content);
                return $response->getContent();
    }
    
    public function getHoursAction(){
        $day = date("Y-m-d", strtotime(str_replace("/", "-", urldecode($this->getRequest()->getPost('dia')))));
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $escolares = new EscolaresModel($dbAdapter);
        $response = $this->getResponse();
        $response->setContent(
            new JsonModel(
                array(
                    'horas'     => $escolares->get_hours($day, $this->getRequest()->getPost('lugar')),
                    'cfg'    => $escolares->get_config()
                )
                ));
        return $response->getContent();
    }
}
