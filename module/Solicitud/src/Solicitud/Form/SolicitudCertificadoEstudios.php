<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudCertificadoEstudios extends Solicitud
{
	
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		
		parent::__construct($name = 'solicitudExtraordinario', $dbadapter);
	
		$this->setAttribute('method', 'post');


		
		$this->add(array(
				'name' => 'Carrera_cursada',
				'type' => 'Zend\Form\Element\Select',
		
				'options' => array(
						'label' => 'Carrera',
						'empty_option' => 'Elija su carrera',
						'value_options' => array(
								'0' => 'Carrera1',
								'1' => 'Carrera2',
								'2' => 'Carrera3',
								'3' => 'Carrera4',
						),
		
				),
				'attributes' => array(
						// Below: HTML5 way to specify that the input will be phone number
						'required' => 'required',
				),
		),
				array (
						'priority' => 280,
				)
		);
	
		$this->add(array(
				'name' => 'Tipo_de_certificado',
				'type' => 'Zend\Form\Element\Radio',
				'options' => array(
						'label' => 'Tipo de certificado',
						'value_options' => array(
								'0' => 'Simple',
								'1' => 'Para Legalizar',

						),
				),
	
		),
				array (
						'priority' => 270,
				)
						);
	
		$this->add(array(
				'name' => 'Tipo_de_titulo',
				'type' => 'Zend\Form\Element\Radio',
				'options' => array(
						'label' => 'Tipo de título',
						'value_options' => array(
								'0' => 'Master',
								'1' => 'Ingenierio/a',

						),
				),
	
		),
				array (
						'priority' => 260,
				)
						);
	
		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'Solicitud_anterior',
				'options' => array(
						'label' => 'Especifique ',
						'value_options' => array(
								'0' => 'Si',
								'1' => 'No',
						),
				),
	
		),
				array (
						'priority' => 250,
				)
						);
	
	
		$this->add(array(
				'name' => 'Aclaraciones',
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
						'label' => 'Aclaraciones'
				),
				'attributes' => array(
						'placeholder' => 'Agregue alguna aclaración aquí...',
						'required' => false,
						'disabled' => false //@todo: getCheckOption from adjunto, si se eligió otro, entonces habilitar especificación
				)
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
					'name' => 'Email',
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
									'name' => 'EmailAddress',
									'options' => array (
											'messages' => array (
													'emailAddressInvalidFormat' => 'Email address format is not invalid'
											)
									)
							),
							array (
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'Email address is required'
											)
									)
							)
					)
			) ) );
	
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'Aclaraciones',
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
	
	
	public function getEmailDeUsuario()
	{
		//@todo: Rescatar email del usuario
	}
	
	
	
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}
	
}