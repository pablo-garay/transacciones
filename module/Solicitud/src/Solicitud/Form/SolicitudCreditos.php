<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudCreditos extends Solicitud
{
	
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		
		parent::__construct($name = 'solicitudCreditos', $dbadapter);
	
			$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'Actividad',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Actividad ',
						'empty_option' => 'Seleccione una actividad ',
						'value_options' => array('0'=>'Materias',
												 '1' => 'Cursos',
												 '2' => '')//$this->getSubjectsOfCareer(),
				),
	
		),
				array (
						'priority' => 290,
				)
				);
	
		$this->add(array(
				'name' => 'Fecha_inicio',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Fecha de Inicio de la Actividad ',
						
					
				),
				'attributes' => array(
					'value' =>  'dd/mm/aaaa',

				),
	
		),
				array (
						'priority' => 280,
				)
						);

		$this->add(array(
				'name' => 'Fecha_fin',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Fecha de Fin de la Actividad ',
		
							
				),
				'attributes' => array(
						'value' =>  'dd/mm/aaaa',
				),
		
		),
				array (
						'priority' => 270,
				)
		);
		
		$this->add(array(
				'name' => 'Descripcion_actividad',
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
						'label' => 'Descripción ',
						'empty_option' => 'Descripcion de la actividad ',

				),
	
		),
				array (
						'priority' => 260,
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
					'name' => 'Descripcion_actividad',
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