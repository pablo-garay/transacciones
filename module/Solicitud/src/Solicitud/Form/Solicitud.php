<?php
namespace Solicitud\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class Solicitud extends Form
{
	public function __construct($name='user') {
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
        		),
        		'options' => array(
        				// This is list of options that we can add to the element.
        				'label' => 'Nombres',
        				// Label es la etiqueta que aparece antes del campo de formulario
        		),
        ));

        $this->add(array(
        		'name' => 'apellidos',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'placeholder' => 'Escriba su apellido...',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Apellidos',
        		),
        ));

        $this->add(array(
        		'name' => 'matricula',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Matrícula',
        				'value_options' => array(
        						'0' => 'Ninguna',
        						'1' => 'Materia1',
        						'2' => 'Materia2',
        				)
        		),
        		'attributes' => array(
        		        // Below: HTML5 way to specify that the input will be phone number
        		        'placeholder' => 'Elija su matrícula...',
        				'required' => 'required',
        		),
        ));

        $this->add(array(
        		'name' => 'carrera',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Carrera',
            		    'value_options' => array(
                                 '0' => 'Carrera1',
                                 '1' => 'Carrera2',
                                 '2' => 'Carrera3',
                                 '3' => 'Carrera4',
                         ),
        		),
        		'attributes' => array(
        				// Below: HTML5 way to specify that the input will be phone number
        				'placeholder' => 'Elija su carrera...',
        				'required' => 'required',
        		),
        ));

        $this->add(array(
        		'name' => 'motivo',
        		'type' => 'Zend\Form\Element\Textarea',
        		'options' => array(
        				'label' => 'Motivo'
        		),
        		'attributes' => array(
        				'placeholder' => 'Agregue alguna información adicional aquí...',
        				'required' => false,
        		)
        ));


        // This is the special code that protects our form beign submitted from automated scripts
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        // This is the submit button
        $this->add(array(
        		'name' => 'enviar',
        		'type' => 'Zend\Form\Element\Submit',
        		'attributes' => array(
        				'value' => 'Enviar',
        				'required' => 'false',
        		),
        ));

	}

	public function getInputFilter()
	{
		if (! $this->filter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory ();

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'email',
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
													'isEmpty' => 'Name is required'
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
													'isEmpty' => 'Name is required'
											)
									)
							)
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