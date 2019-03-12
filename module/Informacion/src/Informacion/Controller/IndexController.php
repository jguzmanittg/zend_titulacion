<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Documentos for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Informacion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Documentos\Model\DocumentosModel;
use DOMPDFModule\View\Model\PdfModel;
use function Zend\View\Renderer\basePath;
date_default_timezone_set('America/Mexico_City');
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
	 $numcontrol = 'mio';
         return new ViewModel( array( 'numcontrol'=> 'mio' ) );
    }

    public function ondexAction()
    {
       return new ViewModel();
       
        $pdf = new PdfModel();
        $view = new ViewModel(array());
        $response=$this->getResponse(); 
        
        $documento=$this->params("doc");
        $numcontrol=$this->params("numcontrol");
        $datos=$this->getAllData($numcontrol);
       
            return $this->forward()->dispatch('Informacion/Controller/Index', 
              array(
              'action' => 'Doc1',
              "documento"=>"vacio",
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
 
    }
    
    private function getAllData($nc){
        //Acceso a la Base de datos
        $dbh = new DocumentosModel($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $data= array(
            "Egresado"=>$dbh->get_EgresadoInfo($nc),
            "Tramite"=>$dbh->get_TramiteEgresado($nc),
            "InfoProp"=>$dbh->get_InformacionProporcionadaPorEgresado($nc),
            "Asesores"=>$dbh->get_AsesoresYJuradoDelEgresado($nc, 'ASESOR'),
            "Jurado"=>$dbh->get_JuradoDelEgresado($nc),
            "JefeAcademia"=>$dbh->get_JefeDeAcademia($nc),
            "Director"=>$dbh->get_ResponsableDelPuesto('DIRECTOR'),
            "Citas"=>$dbh->  get_citaEscolaresHora($nc,'HORA'),      
            
        );
        return $data;
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }

    public function Doc1Action()
    {
       // $estado="SOLICITUD JURADO";
        //$temp=0;
        //switch ($estado){
         //   case "SOLICITUD JURADO":
          //      $temp=1;
           //     break;
            //case "SOLICITUD ASESORES":
             //   $temp=2;
             //   break;
            //case "CITA AGENDADA":
             //   $temp=3;
               // break;
            //case "NOTIFICACION JURADOS":
              //  $temp=4;
                //break;
           // case "CELEBRA ACTO":
             //   $temp=5;
               // break;
            //case "AVISO ACTO":
              //  $temp=6;
                //break;
          //  default:
            //    $temp=0;
              //  break;
       // }

         // if ($temp>=$this->params()->fromRoute('documento')){
          //  $mostrarPDF="SI";
        //}
       // else $mostrarPDF="NO";
        
        //if ($mostrarPDF=="SI")
           // switch ($temp>=$this->params()->fromRoute('documento')){
          //      case 1:
                    $datos=array(
                      "data"=>$this->params()->fromRoute('datos')
                    );
                    $pdf = new PdfModel();
                    $pdf->setVariables($datos);
                    return $pdf;
                    return array();
    //}
    }
      public function Doc2Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc3Action()
    {
        
       $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc4Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc5Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
     public function Doc6Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
     public function Doc7Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc8Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();;
    }
    public function Doc9Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc10Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc11Action()
    {
        
       $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc12Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc13Action()
    {
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc14Action()
    {
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc15Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc16Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc17Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
    public function Doc18Action()
    {
        
        $datos=array(
          "data"=>$this->params()->fromRoute('datos')
        );
        $pdf = new PdfModel();
        $pdf->setVariables($datos);
        return $pdf;
        return array();
    }
}
