<?php

namespace Visualize\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DOMPDFModule\View\Model\PdfModel;


class VisualizeController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function calificacionesAction()
    {
        $fechaBD = "15/03/2014"; //de la solicitud
        $nombreBD = "Luis Fernando"; //nombre del solicitante
        $apellidoBD = "Villalba Vera"; //apellido del solicitante
        $matriculaBD = "59191"; //matricula del solicitante
        $carreraBD= "IF"; //carrera del solicitante
        return array(
            "fechaSol"=>$fechaBD,
            "nombreSol" => $nombreBD,
            "apellidoSol" => $apellidoBD,
            "matriculaSol" => $matriculaBD,
            "carreraSol" => $carreraBD,
            );
    }
    
    public function extraordinarioAction()
    {
        //quitar de la bd
        
        $fechaBD = "15/03/2014"; //de la solicitud
        $nombreBD = "Luis Fernando"; //nombre del solicitante
        $apellidoBD = "Villalba Vera"; //apellido del solicitante
        $matriculaBD = "59191"; //matricula del solicitante
        $carreraBD= "IF"; //carrera del solicitante
        $telefonoBD = "021372255";
        $materiaExa = "Info1"; //materia que quiere extraordinario
        $fechaExa   = "13/03/2014"; //la fecha que se rindio el examen
        $profesorExa = "Mauricio Kreitmayer"; //profesor que tomo el examen
        $motivoExa = "Falta por razones de salud"; //motivo
        $adjuntoExa = "certificado medico";
                
        
        
        return array(
            "fechaSol"=>$fechaBD,
            "nombreSol" => $nombreBD,
            "apellidoSol" => $apellidoBD,
            "matriculaSol" => $matriculaBD,
            "carreraSol" => $carreraBD,
            "materiaExa" => $materiaExa,
            "fechaExa"  =>  $fechaExa,
            "profesorExa"   => $profesorExa,
            "motivoExa" =>  $motivoExa,
            "adjuntoExa" => $adjuntoExa,
            "telefonoSol" => $telefonoBD
        );
        
    }

    public function rupturaCorrelaAction()
    {
        $fechaBD = "15/03/2014"; //de la solicitud
        $nombreBD = "Luis Fernando"; //nombre del solicitante
        $apellidoBD = "Villalba Vera"; //apellido del solicitante
        $matriculaBD = "59191"; //matricula del solicitante
        $carreraBD= "IF"; //carrera del solicitante
        $telefonoBD = "021372255";
        $materiaRC = "MPI";
        $motivoRC = "Para tomar la materia INFO1";
        $adjuntoRC = "certificado de trabajo";
        return array(
            "fechaSol"=>$fechaBD,
            "nombreSol" => $nombreBD,
            "apellidoSol" => $apellidoBD,
            "matriculaSol" => $matriculaBD,
            "telefonoSol" => $telefonoBD,
            "carreraSol" => $carreraBD,
            "materiaRC" => $materiaRC,
            "motivoRC" =>  $motivoRC,
            "adjuntoRC" => $adjuntoRC,
            "firma" => "ALUMNO"
            );
    }


}

