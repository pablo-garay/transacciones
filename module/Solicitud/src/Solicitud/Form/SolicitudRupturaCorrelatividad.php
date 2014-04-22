<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudRupturaCorrelatividad extends Solicitud
{
	
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		
		parent::__construct($name = 'solicitudRupturaCorrelatividad', $dbadapter);
	
		$this->setAttribute('method', 'post');
	
		$this->add(array(
				'name' => 'Semestre',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Semestre ',
						'empty_option' => 'Seleccione su semestre..',
						'value_options' => array(''=>'')//$this->getSubjectsOfCareer(),
				),
		
		),
				array (
						'priority' => 290,
				)
		);
		
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
						'priority' => 280,
				)
				);
	
		$this->add(array(
				'name' => 'Semestre_asignatura',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Semestre de Asignatura ',
						'empty_option' => 'Seleccione su semestre..',
						'value_options' => array(''=>'')//$this->getSubjectsOfCareer(),
				),
		
		),
				array (
						'priority' => 270,
				)
		);
		
		$this->add(array(
				'name' => 'Prerrequisito',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Asignatura Prerrequisito ',
						'empty_option' => 'Seleccione una asignatura..',
						'value_options' => array(''=>'')//$this->getSubjectsOfCareer(),
				),
		
		),
				array (
						'priority' => 260,
				)
		);
		
		$this->add(array(
				'name' => 'Semestre_prerrequisito',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Semestre de Asignatura Prerrequisito ',
						'empty_option' => 'Seleccione su semestre..',
						'value_options' => array(''=>'')//$this->getSubjectsOfCareer(),
				),
		
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
                    'name' => 'Semestre',
                    'filters' => array(
                            array ( 'name' => 'digits' ),
    
                    ),
                    'validators' => array (
                            array (
                                    'name' => 'digits',
                                    'options' => array (
                                            'messages' => array(
                                    						'notDigits' => 'Solo especifique en números',	
                                    						),
                                    )
                            ),
                    )
            )));
			
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
					'name' => 'Semestre_asignatura',
					'filters' => array(
							array ( 'name' => 'digits' ),
			
					),
					'validators' => array (
							array (
									'name' => 'digits',
									'options' => array (
											'messages' => array(
													'notDigits' => 'Solo especifique en números',
											),
									)
							),
					)
			)));
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Prerrequisito',
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
					'name' => 'Semestre_prerrequisito',
					'filters' => array(
							array ( 'name' => 'digits' ),
								
					),
					'validators' => array (
							array (
									'name' => 'digits',
									'options' => array (
											'messages' => array(
													'notDigits' => 'Solo especifique en números',
											),
									)
							),
					)
			)));
			
			
	
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
	
	public function getPrerrequisitoDeMateria()
	{
		//@todo: Rescatar los asignaturas según la carrera elegida en el combo
		$carreraElegida = $this->get('carrera')->getAttribute('value');
	
	}
	

	

	
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}
	
}