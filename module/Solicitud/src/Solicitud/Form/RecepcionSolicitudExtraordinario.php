<?php
namespace Solicitud\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;


class RecepcionSolicitudExtraordinario extends Form
{

	protected $adapter;
	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos
		$this->adapter = $dbadapter; //Asignación de nuestro adaptador de base de datos
		parent::__construct('solicitud');

		$this->setAttribute('method', 'post');


		//This is the submit button


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

		// This is the special code that protects our form beign submitted from automated scripts
		$this->add(array(
				'name' => 'csrf',
				'type' => 'Zend\Form\Element\Csrf',
		));



	}



	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}

}
