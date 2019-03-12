<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Documentos for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Documentos\Controller;

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
        $pdf = new PdfModel();
        $view = new ViewModel(array());
        $response=$this->getResponse(); 
        
        $documento=$this->params("doc");
        $numcontrol=$this->params("numcontrol");
        $datos=$this->getAllData($numcontrol);
       
        switch ($documento){
          case 1:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc1',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 2:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc2',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 3:
            return $this->forward()->dispatch('Documentos/Controller/Index',  
              array(
              'action' => 'Doc3',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 4:
            return $this->forward()->dispatch('Documentos/Controller/Index',
              array(
              'action' => 'Doc4',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 5:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc5',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 6:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc6',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 7:
            return $this->forward()->dispatch('Documentos/Controller/Index',  
              array(
              'action' => 'Doc7',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 8:
            return $this->forward()->dispatch('Documentos/Controller/Index',  
              array(
              'action' => 'Doc8',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 9:
            return $this->forward()->dispatch('Documentos/Controller/Index',  
              array(
              'action' => 'Doc9',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 10:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc10',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
         case 11:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc11',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 12:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc12',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 13:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc13',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
          case 14:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc14',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
            case 15:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc15',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
            case 16:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc16',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
            case 17:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc17',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;
            case 18:
            return $this->forward()->dispatch('Documentos/Controller/Index', 
              array(
              'action' => 'Doc18',
              "documento"=>$documento,
              "numcontrol"=>$numcontrol,
              "datos"=>$datos));
            break;

         


        }
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
            "Protocolo" =>"",            
        );
        $data["Protocolo"]= $dbh->get_OpcionProtocolaria ($data["Tramite"]["opcion"]);
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
