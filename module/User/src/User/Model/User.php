<?php
namespace User\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature;

class User extends AbstractTableGateway
{
	public function __construct()
	{
		$this->table = 'usuarios';
		$this->featureSet = new Feature\FeatureSet();
		$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
		$this->initialize();
	}

	public function insert($set)
	{
		unset($set['contrasena_verify']);
		$set['contrasena'] = md5($set['contrasena']); // better than clear text
												 	 // passwords
		return parent::insert($set);
	}
}