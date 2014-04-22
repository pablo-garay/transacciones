<?php
namespace Solicitud\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class Solicitud extends Form
{
	protected $dbAdapter;

	//parámetro del constructor: adaptador de la base de datos
	public function __construct( $name = 'solicitud', AdapterInterface $databaseAdapter) {
		$this->dbAdapter = $databaseAdapter; //Asignación de nuestro adaptador de base de datos
		parent::__construct($name);

		$this->setAttribute('method', 'post');

       // Asi es como definimos un elemento (en este caso tipo texto)
        $this->add(array(
        		'name' => 'nombres',// the unique name of the element in the form.
                                	//Ex: <input name="..."
        		'type' => 'Zend\Form\Element\Text',
        		// The above must be valid Zend Form element.
        		// You can also use short names as “Text” instead of “Zend\Form\Element\Text
        		'attributes' => array(
        		// These are the attributes that are passed directly to the HTML element
        				'placeholder' => 'Escriba su nombre...', // HTM5 placeholder attribute
        				'required' => 'required', // Ex: <input required="true"
        				'value' => $this->getNombres(),
        		),
        		'options' => array(
        				// This is list of options that we can add to the element.
        				'label' => 'Nombres', // Label es la etiqueta que aparece antes del campo de formulario
        		),

        )
        , array (
        		'priority' => 700,
        ));

		$this->add ( array (
				'name' => 'apellidos',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array (
						'placeholder' => 'Escriba su apellido...',
						'required' => 'required',
						'value' => $this->getApellidos ()
				),
				'options' => array (
						'label' => 'Apellidos'
				)
		)
		, array (
				'priority' => 600,
        ) );

        $this->add(array(
        		'name' => 'matricula',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Matrícula',
        				'empty_option' => 'Elija su matricula',
        				'value_options' => $this->getMatricula(),
        		),
        		'attributes' => array(
        		        'placeholder' => 'Elija su matrícula...',
        				'required' => 'required',
        		),
        )
        , array (
        		'priority' => 500,
        ) );

		$this->add ( array (
				'name' => 'carrera',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Carrera',
						'value_options' => $this->getCarrera ()
				),
				'attributes' => array (
						// Below: HTML5 way to specify that the input will be phone number
						'placeholder' => 'Elija su carrera...',
						'required' => 'required'
				)
		), array (
				'priority' => 400,
		) );

        $this->add(array(
        		'name' => 'telefono',
        		'type' => 'Zend\Form\Element\Text',
        		'options' => array(
        				'label' => 'Teléfono:',

        		),
        		'attributes' => array (
        				'value' => $this->getTelefono(), // @todo getphone
        				//'disabled' => 'disabled'
        		),

		), array (
				'priority' => 300,
		) );




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
					'name' => 'nombres',
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
													'isEmpty' => 'Nombre requerido'
											)
									)
							)
					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'apellidos',
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
													'isEmpty' => 'Apellido requerido'
											)
									)
							)
					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'matricula',
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
							)
					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'carrera',
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
													'isEmpty' => 'Carrera requerida'
											)
									)
							)
					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'telefono',
					'filters' => array(
							array ( 'name' => 'digits' ),
							array ( 'name' => 'stringtrim' ),
					),
					'validators' => array (
							array (
									'name' => 'regex',
									'options' => array (
											'pattern' => '/^[\d-\/]+$/',
									)
							),
					)
			)));


			// @todo: posiblemente agregar filtros a los demas campos

			$this->filter = $inputFilter;
		}

		return $this->filter;
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}

	public function getNombres()
	{
		//@todo: Rescatar los datos de usuario según el usuario de la sesión actual

		$sql       = 'SELECT usuario, nombres FROM usuarios LIMIT 1';

		$statement = $this->dbAdapter->query($sql);
		$result    = $statement->execute();

		$selectData = array();

		foreach ($result as $res) {
			// retornar nombre del usuario
			return $res['nombres'];
		}

		return FALSE; // no se encontraron resultados
	}

	public function getApellidos()
	{
		//@todo: Rescatar los datos de usuario según el usuario de la sesión actual

		$sql       = 'SELECT usuario, apellidos FROM usuarios LIMIT 1';

		$statement = $this->dbAdapter->query($sql);
		$result    = $statement->execute();

		$selectData = array();

		foreach ($result as $res) {
			// retornar nombre del usuario
			return $res['apellidos'];
		}

		return FALSE; // no se encontraron resultados
	}

	public function getMatricula()
	{
		//@todo: Rescatar los datos de usuario según el usuario de la sesión actual

		$sql       = 'SELECT usuario, telefono FROM usuarios';

		$statement = $this->dbAdapter->query($sql);
		$result    = $statement->execute();

		$selectData = array();

		foreach ($result as $res) {
			$selectData[$res['telefono']] = $res['telefono'];
		}
		return $selectData;
	}

	public function getTelefono()
	{
		//@todo: Rescatar los datos de usuario según el usuario de la sesión actual

		$sql       = 'SELECT usuario, telefono FROM usuarios';

		$statement = $this->dbAdapter->query($sql);
		$result    = $statement->execute();

		$selectData = array();

		foreach ($result as $res) {
			return $res['telefono'];
		}
		return FALSE;
	}

	public function getCarrera()
	{
		//@todo: Rescatar los datos de usuario según el usuario de la sesión actual

		$sql       = 'SELECT usuario, telefono FROM usuarios';

		$statement = $this->dbAdapter->query($sql);
		$result    = $statement->execute();

		$selectData = array();

		foreach ($result as $res) {
			$selectData[$res['telefono']] = $res['telefono'];
		}
		return $selectData;
	}


}