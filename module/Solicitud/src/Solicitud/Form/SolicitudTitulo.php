<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudTitulo extends Solicitud
{
	
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		
		parent::__construct($name = 'solicitudTitulo', $dbadapter);
	
		$this->setAttribute('method', 'post');


	
		$this->add(array(
				'name' => 'Nombre_titulo',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Título ',
						'empty_option' => 'Seleccione un título..',
						'value_options' => array(
								'0' => 'Ingeniero Informático',
								'1' => 'Otro'
						),
				),
		),
				array (
						'priority' => 280,
				)
						);
		
		
		$this->add(array(
				'name' => 'Fotocopia_cedula',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
						'label' => 'Fotocopia de cédula ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 270,
				)
		);
		
		$this->add(array(
				'name' => 'Fotocopia_certificado_nacimiento',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
						'label' => 'Fotocopia de certificado de nacimiento ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 265,
				)
		);
		
		$this->add(array(
				'name' => 'Fotocopia_certificado_matrimonio',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
						'label' => 'Fotocopia de certificado de matrimonio ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 260,
				)
		);
		
		$this->add(array(
				'name' => 'Postgrado',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
						'label' => 'Marque si es un título de postgrado ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 255,
				)
		);
		
		$this->add(array(
				'name' => 'Fotocopia_de_titulo_de_grado ',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
						'label' => 'Fotocopia de titulo de grado (egresados de otras universidades) ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 250,
				)
		);
		
		$this->add(array(
				'name' => 'Fotocopia_simple_de_titulo',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
						'label' => 'Fotocopia simple de titulo de grado (egresados UCA) ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 245,
				)
		);
		
		$this->add(array(
				'name' => 'Tipo', //campo de la tabla adjuntos, tipo de doc adjunto
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label' => 'Otro Documento ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 240,
				)
		);
		
		$this->add(array(
				'name' => 'Descripcion', //campo de la tabla adjuntos, descripcion de doc adjunto
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
						'label' => 'Descripción de Otro Documento ',
						//'value_options' => 'Curso completo',
				),
		),
				array (
						'priority' => 240,
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
					'name' => 'Fecha_extraordinario',
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
					'name' => 'Profesor',
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
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'El Profesor es requerido'
											),
											'allowWhiteSpace' => true,
									)
							)
					)
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
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Especificacion_adjunto',
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
	
	public function getProfesoresDeAsignatura()
	{
		//@todo: Rescatar profesores titulares según la asignatura elegida
	}
	
	public function getFechaDeExtraordinario()
	{
		//@todo: Rescatar los datos de usuario según la asignatura elegida
	}
	

	
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}
	
}