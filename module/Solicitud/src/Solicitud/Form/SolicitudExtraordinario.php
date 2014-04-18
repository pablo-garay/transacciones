<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudExtraordinario extends Solicitud
{

	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos

		parent::__construct($name = 'extraordinario', $dbadapter);

		$this->setAttribute('method', 'post');



		$this->add(array(
				'name' => 'asignatura',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Asignatura:',
						'value_options' => $this->getAsignatura(),
				),

		));

		$this->add(array(
				'name' => 'fechaExamen',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Fecha de Examen:',
						'value_options' => array(
								'0' => 'FechadeExamen',
						),
				),

		));

		$this->add(array(
				'name' => 'profesor',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Profesor:',
						'value_options' => array(
								'0' => 'Profesor1',
								'1' => 'Profesor2'
						),
				),

		));

		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'motivo',
				'options' => array(
						'label' => 'Motivo',
						'value_options' => array(
								'0' => 'Enfermedad',
								'1' => 'Duelo',
								'2' => 'Trabajo',
								'3' => 'Otro'
						),
				),

		));

		$this->add(array(
				'name' => 'especificacionMotivo',
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
						'label' => 'Especificación de Motivo'
				),
				'attributes' => array(
						'placeholder' => 'Agregue alguna información adicional aquí...',
						'required' => false,
						'disabled' => false //@todo: getCheckOption from motivo, si se eligió otros, entonces habilitar especificación
				)
		));

		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'adjunto',
				'options' => array(
						'label' => 'Documento Adjunto',
						'value_options' => array(
								'0' => 'Certificado Médico',
								'1' => 'Certificado de Trabajo',
								'2' => 'Otro'
						),
				),

		));

		$this->add(array(
				'name' => 'especificacionAdjunto',
				'type' => 'Zend\Form\Element\Textarea',
				'options' => array(
						'label' => 'Especificación de documento adjunto'
				),
				'attributes' => array(
						'placeholder' => 'Agregue la descripción del documento adjunto aquí...',
						'required' => false,
						'disabled' => false //@todo: getCheckOption from adjunto, si se eligió otro, entonces habilitar especificación
				)
		));

		// This is the special code that protects our form beign submitted from automated scripts
		$this->add(array(
				'name' => 'csrf',
				'type' => 'Zend\Form\Element\Csrf',
		));

		//This is the submit button
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



			// @todo: posiblemente agregar filtros a los demas campos

			$this->filter = $inputFilter;
		}

		return $this->filter;
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('It is not allowed to set the input filter');
	}

	public function getAsignatura()
	{
		//@todo: Rescatar los asignaturas según la carrera elegida en el combo
		$carreraElegida = $this->get('carrera')->getAttribute('value');

	}

	public function getFechaExamen()
	{
		//@todo: Rescatar los datos de usuario según la asignatura elegida
	}

	public function getProfesor()
	{
		//@todo: Rescatar profesores titulares según la asignatura elegida
	}


}