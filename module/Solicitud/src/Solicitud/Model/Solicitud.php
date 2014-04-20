<?php
namespace Solicitud\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature;

class Solicitud extends AbstractTableGateway
{

	public function __construct()
	{

		$this->table = 'solicitudes';
		$this->featureSet = new Feature\FeatureSet();
		$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
		$this->featureSet->addFeature(new Feature\SequenceFeature('solicitud','solicitudes_solicitud_seq'));
		$this->initialize();
	}

	public function insert($set)
	{
		// $fields = $this->getColumns(); // obtener columnas de tabla

		$solicitudData = array(
			'usuario_solicitante' => 1,
			'carrera' => $set['carrera'],
			'materia' => $set['materia'],
		);

		parent::insert($solicitudData);
		return $this->lastInsertValue;
	}
}

class SolicitudExtraordinario extends AbstractTableGateway
{

	public function __construct()
	{

		$this->table = 'solicitud_de_extraordinario';
		$this->featureSet = new Feature\FeatureSet();
		$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
		$this->initialize();
	}

	public function insert($set)
	{
		$extraordinarioData = array(
			'solicitud' => $set['solicitud'],
			'fecha_extraordinario' => $set['fecha_extraordinario'],
			'motivo' => $set['motivo'],
		);

		return parent::insert($extraordinarioData);
	}
}
