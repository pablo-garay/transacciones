<?php
namespace User\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature;
class User extends AbstractTableGateway
{

	public function __construct()
	{

		$this->table = 'solicitudes';
		$this->featureSet = new Feature\FeatureSet();
		$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
		$this->initialize();
	}
}
