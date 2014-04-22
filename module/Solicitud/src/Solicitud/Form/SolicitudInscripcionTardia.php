<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudInscripcionTardia extends Solicitud
{
	
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		
		parent::__construct($name = 'solicitudInscripcionTardia', $dbadapter);
	
			$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'Asignatura',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Asignatura:',
						'empty_option' => 'Seleccione una asignatura..',
						'value_options' => array(''=>'')//$this->getSubjectsOfCareer(),
				),
	
		),
				array (
						'priority' => 290,
				)
				);
	
		$this->add(array(
				'name' => 'Fecha_de_examen',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label' => 'Fecha de Examen:',
						
					
				),
				'attributes' => array(
					'value' =>  'dd/mm/aaaa',
					'disabled' => 'disabled'
				),
	
		),
				array (
						'priority' => 280,
				)
						);
	
		$this->add(array(
				'name' => 'Oportunidad',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Oportunidad ',
						'empty_option' => 'Elija una Oportunidad..',
						'value_options' => array(
								'0' =>  1,
								'1' =>  2,
								'3' => 	3
						),
				),
	
		),
				array (
						'priority' => 270,
				)
						);
	
		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'Motivo',
				'options' => array(
						'label' => 'Motivo',
						'value_options' => array(
								'0' => 'Enfermedad',
								'1' => 'Duelo',
								'2' => 'Trabajo',
								'3' => 'Repitente',
								'4' => 'Otro'
						),
				),
	
		),
				array (
						'priority' => 260,
				)
						);
	
		$this->add(array(
				'name' => 'Especificacion_motivo',
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
						'label' => 'Especificación de Motivo'
				),
				'attributes' => array(
						'placeholder' => 'Agregue alguna información adicional aquí...',
						'required' => false,
						'disabled' => false //@todo: getCheckOption from motivo, si se eligió otros, entonces habilitar especificación
				)
		),
				array (
						'priority' => 250,
				)
				);
	
	
	
		// This is the special code that protects our form beign submitted from automated scripts
		$this->add(array(
				'name' => 'csrf',
				'type' => 'Zend\Form\Element\Csrf',
		));
	

	
	}
	
	public function getInputFilter()
	{
		if (! $this->filter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory ();
	
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Asignatura',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'alnum',
									'options' => array (
											'messages' => array (
													'notAlnum' => 'Se requieren sólo números y letras'
											),
											'allowWhiteSpace' => true,
									)
							),
							
					)
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Fecha_de_examen',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'date',
									'options' => array (
// 											'messages' => array (
// 													'false' => 'Se requiere formato fecha'
// 											),
											'locale' => 'en', 
											'format' => 'Y'
									)
							),
								
					)
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Oportunidad',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),

			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Especificacion_motivo',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),

			) ) );
			
			
			
			
	
			// @todo: posiblemente agregar filtros a los demas campos
	
			$this->filter = $inputFilter;
		}
	
		return $this->filter;
	}
	
	public function getOptionsForSelect()
	{
		$dbAdapter = $this->adapter;
		$sql       = 'SELECT usuario,nombres FROM usuarios';
	
		$statement = $dbAdapter->query($sql);
		$result    = $statement->execute();
	
		$selectData = array();
	
		foreach ($result as $res) {
			$selectData[$res['usuario']] = $res['nombres'];
		}
		return $selectData;
	}
	
	
	public function getAsignaturasDeCarrera()
	{
		//@todo: Rescatar los asignaturas según la carrera elegida en el combo
		$carreraElegida = $this->get('carrera')->getAttribute('value');
	
	}
	
	public function getFechaDeExamen()
	{
		//@todo: Rescatar fecha de examen
	}
	
	

	
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}
	
}