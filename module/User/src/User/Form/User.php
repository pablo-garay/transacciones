<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class User extends Form
{
	public function __construct($name='user') {
		parent::__construct($name);

		$this->setAttribute('method', 'post');

        // This is how we define the "email" element
       $this->add(array(
            'name' => 'email', // the unique name of the element in the form.
                                //Ex: <input name="..."
            'type' => 'Zend\Form\Element\Email',
// The above must be valid Zend Form element.
// You can also use short names as “email” instead of “Zend\Form\Element\Email
            'options' => array(
                // This is list of options that we can add to the element.
                'label' => 'Email:'
                // Label is the text that should who before the form field
            ),
            'attributes' => array(
            // These are the attributes that are passed directly to the HTML element
                'type' => 'email', // Ex: <input type="email"
                // 'required' => true, // Ex: <input required="true"
                'placeholder' => 'Su dirección de email...', // HTM5 placeholder attribute
            )
        ));

        $this->add(array(
        		'name' => 'nombres',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'placeholder' => 'Escriba su nombre...',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Nombres',
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
        		'name' => 'fecha_nacimiento',
        		'type' => 'Zend\Form\Element\Date',
        		'attributes' => array(
        				'placeholder' => 'Fecha de nacimiento...',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Fecha de Nacimiento',
        		),
        ));

		$this->add(array(
				'name' => 'sexo',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array(
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Sexo',
						'value_options' => array(
								'M' => 'Masculino',
								'F' => 'Femenino',
						),
				),

		));

        $this->add(array(
        		'name' => 'direccion',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'placeholder' => 'Escriba su dirección...',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Dirección',
        		),
        ));

        $this->add(array(
        		'name' => 'telefono',
        		'options' => array(
        				'label' => 'Teléfono'
        		),
        		'attributes' => array(
        		        // Below: HTML5 way to specify that the input will be phone number
        				'type' => 'tel',
        		        'placeholder' => 'Escriba su teléfono...',
        				'required' => 'required',
        		        // Below: HTML5 way to specify the allowed characters
        				'pattern'  => '^[\d-/]+$'
        		),
        ));

        $this->add(array(
        		'name' => 'contrasena',
        		'type' => 'Zend\Form\Element\Password',
        		'attributes' => array(
        				'placeholder' => 'Indique contraseña aquí...',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Contraseña',
        		),
        ));

        $this->add(array(
        		'name' => 'contrasena_verify',
        		'type' => 'Zend\Form\Element\Password',
        		'attributes' => array(
        				'placeholder' => 'Confirme contraseña aquí...',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Verifique contraseña',
        		),
        ));

        // This is the special code that protects our form beign submitted from automated scripts
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        // This is the submit button
        $this->add(array(
        		'name' => 'submit',
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
													'isEmpty' => 'Se requiere email'
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
													'isEmpty' => 'Se requiere nombres'
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
													'isEmpty' => 'Se requiere apellidos'
											)
									)
							)
					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'fecha_nacimiento',
					'filters' => array (
							array ('name' => 'StripTags'),
							array ('name' => 'StringTrim'),
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									// @Validar fecha minima
							)
					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'sexo',
					'filters' => array(
							array ( 'name' => 'StripTags' ),
							array ( 'name' => 'StringTrim' ),
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									// @todo validar que sea caracter M o F
							),
					)
			)));

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'direccion',
					'filters' => array(
							array ( 'name' => 'StripTags' ),
							array ( 'name' => 'StringTrim' ),
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									// @validate que sea Alphanum
							),
					)
			)));

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

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'contrasena',
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
													'isEmpty' => 'Password is required'
											)
									)
							)
					)
			)));

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'contrasena_verify',
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
									'name' => 'identical',
									'options' => array (
											'token' => 'contrasena'
									)
							)
					)

			) ) );

			$this->filter = $inputFilter;
		}

		return $this->filter;
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}

}