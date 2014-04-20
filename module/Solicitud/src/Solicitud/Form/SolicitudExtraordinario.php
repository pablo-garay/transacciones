<?php
namespace Solicitud\Form;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Db\Adapter\AdapterInterface;

class SolicitudExtraordinario extends Solicitud
{

	public function __construct(AdapterInterface $dbadapter) { //parámetro del constructor: adaptador de la base de datos

		parent::__construct($name = 'extraordinario', $dbadapter);

		$this->setAttribute('method', 'post');



		$this->add(array(
				'name' => 'materia',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label' => 'Asignatura:',
						'value_options' => $this->getAsignaturasDeCarrera(),
				),

		));

		$this->add(array(
				'name' => 'fecha_extraordinario',
				'type' => 'Zend\Form\Element\Date',
				'options' => array(
						'label' => 'Fecha de Examen:',
// 						'value_options' => array(
// 								'0' => 'FechadeExamen',
// 						),
				),

		));

		$this->add(array(
				'name' => 'motivo',
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
			// DEBEMOS inicializar filter del padre
			$inputFilter = parent::getInputFilter();
			$factory = new InputFactory ();

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'materia',
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

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'fecha_extraordinario',
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
	// // 											'messages' => array (
	// // 													'false' => 'Se requiere formato fecha'
	// // 											),
	// 									)
							),

					)
			) ) );

			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'motivo',
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
		$sql       = 'SELECT usuario, nombres FROM usuarios';

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
		$dbAdapter = $this->dbAdapter;
		$sql       = 'SELECT solicitud, materia FROM solicitudes';

		$statement = $dbAdapter->query($sql);
		$result    = $statement->execute();

		$selectData = array();

		foreach ($result as $res) {
			$selectData[$res['materia']] = $res['materia'];
		}
		return $selectData;

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