<?php
/**
 * Zend Framework (http://framework.zend.com/)
 * @author    Rhanxu
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\LoginModel;
use Application\Model\ConfigModel;
use Application\Model\AddModel;
use Zend\Session\Container;
date_default_timezone_set('America/Mexico_City');

class IndexController extends AbstractActionController{
    
    public function indexAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $config = new ConfigModel($dbAdapter);
        $api = $config->get_config();
        return new ViewModel(array('api'=>$api[0]['api']));
    }
    
    public function egresadoAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $login = new LoginModel($dbAdapter);
        //Prepara los datos de inicio de sesión, la contraseña es encriptada.
        $user = $this->getRequest()->getPost('username_e');
        $pass = $this->getRequest()->getPost('password_e');
        $pass = openssl_digest($pass, "sha512");
        //Si el número de control es númerico, procede. 
        //Atención: Si el egresado se maneja con valores alfanuméricos, se debe modificar
        if (is_numeric($user)){
            $user_data = $login->egresado($user, $pass);
            //Si se encuentra un usuario con las credenciales se procede al inicio de sesión.
            if (sizeof($user_data)>0){
                return $this->startEgresadoSessionAction($user_data);
            }
            //Si el usuario es válido pero aún no se ha registrado, se recuperan los datos de POST
            //y son redireccionados al método nuevo.
            else if(sizeof($login->existeEgresado($user))<1)
                return $this->forward()->dispatch('Application\Controller\Index', array(
                    'action' => 'nuevo',
                    'nc' => $this->getRequest()->getPost('username_e'),
                    'nombre' => $this->getRequest()->getPost('nombre_e'),
                    'apellidos' => $this->getRequest()->getPost('apellidos_e'),
                    'nombre_completo' => $this->getRequest()->getPost('nombreComp_e'),
                    'carrera' => $this->getRequest()->getPost('carrera_e'),
                    'clave' => $this->getRequest()->getPost('clave_e'),
                    'adeudo' => $this->getRequest()->getPost('adeudo_e')
                ));
        }
        return $this->redirect()->toUrl('../');        
    }
    
    public function nuevoAction(){
        //Redirecciona a la vista "nuevo" y recupera los datos enviados desde el método que le invoca.
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $info = new addModel($dbAdapter);
        return new ViewModel(
            array(
                'nc' => $this->params()->fromRoute('nc'),
                'nombre' => $this->params()->fromRoute('nombre'),
                'apellidos' => $this->params()->fromRoute('apellidos'),
                'completo' => $this->params()->fromRoute('nombre_completo'),
                'carrera' => $this->params()->fromRoute('carrera'),
                'clave' => $this->params()->fromRoute('clave'),
                'adeudo' => $this->params()->fromRoute('adeudo'),
                'planes' => $info->get_Planes(),
                'carreras' => $info->get_Licenciaturas()
            )
        );
    }
    
    public function guardarAction(){
        //Prepara los datos del egresado para ser ingresados a la BD.
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $add = new AddModel($dbAdapter);
        $pass = $this->getRequest()->getPost('password');
        $pass = openssl_digest($pass, "sha512");
        $data = array(
            'numControl' => $this->getRequest()->getPost('numControl'),
            'nombre' => $this->getRequest()->getPost('nombre'),
            'apellidos' => $this->getRequest()->getPost('apellidos'),
            'nombreComp' => $this->getRequest()->getPost('nombreComp'),
            'carrera' => $this->getRequest()->getPost('carrera'),
            'planEstudios' => $this->getRequest()->getPost('plan'),
            'correo' => $this->getRequest()->getPost('correo'),
            'password' => $pass,
            'deudor' => $this->getRequest()->getPost('adeudo')
        );
        
        //Ingresa los datos.
        $add->addEgresado($data);
        
        //Prepara el inicio de sesión con los valores recién ingresados.
        $login = new LoginModel($dbAdapter);
        $user_data = $login->egresado($data['numControl'], $pass);
        if (sizeof($user_data)>0){
            $this->startEgresadoSessionAction($user_data);
        }
    }
    
    public function startEgresadoSessionAction($user_data){
        $user = new Container('nc');
        $user
            ->usercontrol = $user_data[0]['numControl'];
        $user
            ->username = $user_data[0]['nombre'];
        $user
            ->plan = $user_data[0]['planEstudios'];
        $user
            ->adeudo = $user_data[0]['deudor'];
        $user
            ->status = $user_data[0]['status'];
        $this->redirect()->toUrl('../../egresado');
    }
    
    public function divisionAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $login = new LoginModel($dbAdapter);
        //Prepara los datos de inicio de sesión, la contraseña es encriptada.
        $user = $this->getRequest()->getPost('username_d');
        $pass = $this->getRequest()->getPost('password_d');
        $pass = openssl_digest($pass, "sha512");
        //Si el número de tarjeta es númerico, procede.
        if (is_numeric($user)){
            $user_data = $login->division($user, $pass);
            //Si se encuentra un usuario con las credenciales se procede al inicio de sesión.
            if (sizeof($user_data)>0){
                return $this->startDivisionSessionAction($user_data);
            }
        }
        return $this->redirect()->toUrl('../');        
    }
    
    public function startDivisionSessionAction($data){
        $division = new Container('Division');
        $division->userdivision=true;
        $this->redirect()->toUrl('../../division');
    }
    
    public function academiaAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $login = new LoginModel($dbAdapter);
        //Prepara los datos de inicio de sesión, la contraseña es encriptada.
        $user = $this->getRequest()->getPost('username_a');
        $pass = $this->getRequest()->getPost('password_a');
        $pass = openssl_digest($pass, "sha512");
        //Si el número de tarjeta es númerico, procede.
        if (is_numeric($user)){
            $user_data = $login->academia($user, $pass);
            //Si se encuentra un usuario con las credenciales se procede al inicio de sesión.
            if (sizeof($user_data)>0){
                return $this->startAcademiaSessionAction($user_data);
            }
        }
        return $this->redirect()->toUrl('../');
    }
    
    public function startAcademiaSessionAction($data){
        $academia = new Container('Academia');
        $academia->useracademia=true;
        $academia->carrera=$data[0]["carrera"];
        $this->redirect()->toUrl('../../academia');
    }
    
    public function escolaresAction(){
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $login = new LoginModel($dbAdapter);
        //Prepara los datos de inicio de sesión, la contraseña es encriptada.
        $user = $this->getRequest()->getPost('username_es');
        $pass = $this->getRequest()->getPost('password_es');
        $pass = openssl_digest($pass, "sha512");
        //Si el número de tarjeta es númerico, procede.
        if (is_numeric($user)){
            $user_data = $login->escolares($user, $pass);
            //Si se encuentra un usuario con las credenciales se procede al inicio de sesión.
            if (sizeof($user_data)>0){
                return $this->startEscolaresSessionAction($user_data);
            }
        }
        return $this->redirect()->toUrl('../');
    }
    
    public function startEscolaresSessionAction($data){
        $academia = new Container('Escolares');
        $academia->userescolares=true;
        $this->redirect()->toUrl('../../escolares');
    }
    
    public function contactoAction(){
        return new ViewModel();
    }
}
