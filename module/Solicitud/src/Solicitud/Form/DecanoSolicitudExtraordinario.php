<?php
namespace Solicitud\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;


class DecanoSolicitudExtraordinario extends Form
{

	protected $adapter;
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		$this->adapter = $dbadapter; //Asignación de nuestro adaptador de base de datos
		parent::__construct('solicitud');

		$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'Observaciones', // de la tabla solicitudes
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
					//	'label' => 'Observaciones',

				),
				'attributes' => array(
							'placeholder' => 'Agregue alguna observación aquí..',
				),

		),
				array (
						'priority' => 500,
				)
		);


		//This is the submit button
		$this->add(array(
				'name' => 'Aprobar',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Aprobar',
						'required' => 'false',

				),
		),
				array (
						'priority' => 475,
				)
		);

		$this->add(array(
				'name' => 'Pendiente',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Pendiente',
						'required' => 'false',

				),
		),
				array (
						'priority' => 490,
				)
		);

		$this->add(array(
				'name' => 'Anular',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Anular',
						'required' => 'false',

				),
		),
				array (
						'priority' => 480,
				)
		);



		$this->add(array(
				'name' => 'Rechazar',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Rechazar',
						'required' => 'false',

				),
		),
				array (
						'priority' => 470,
				)
		);

		$this->add(array(
				'name' => 'VistoBueno',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Visto Bueno y Derivar',
						'required' => 'false',

				),
		),
				array (
						'priority' => 460,
				)
		);


		$this->add(array(
				'name' => 'EnviarCorreo',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Enviar Correo',
						'required' => 'false',

				),
		),
				array (
						'priority' => 450,
				)
		);

		$this->add(array(
				'name' => 'Imprimir',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Imprimir',
						'required' => 'false',

				),
		),
				array (
						'priority' => 440,
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
					'name' => 'Observaciones',
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
									'name' => 'notEmpty',
// 									'options' => array (
// 											'messages' => array (
// 													'notAlnum' => 'Se requieren sólo números y letras'
// 											),
// 											'allowWhiteSpace' => true,
// 									)
							),
					)
			) ) );




			// @todo: posiblemente agregar filtros a los demas campos

			$this->filter = $inputFilter;
		}

		return $this->filter;
	}






	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}

}
