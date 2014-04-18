<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Solicitud for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Solicitud\Controller;

use Solicitud\Form\SolicitudExtraordinario as ExtraordinarioForm;
use Zend\Mvc\Controller\AbstractActionController;
use Solicitud\Service\Factory\Database as DatabaseAdapter;

class FormularioController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function createAction()
    {
    	//instanciar la clase cuyo metodo nos devuelve el adaptador de nuestra bd
    	$database = new DatabaseAdapter();
    	//llamamos al metodo que nos devuelve el adaptador de bd
    	$dbAdapter = $database->createService($this->getServiceLocator());

        $form = new ExtraordinarioForm($dbAdapter);
        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                // Notice: make certain to merge the Files also to the post data
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
            	// You can use the standard way of instantiating a table gateway
            	//$model = new UserModel();
            	// Or if you have many db tables that do need special treatment of the incoming data
            	// you can use the table gateway service
                // @todo: guardar la solicitud en DB

/*             	$model = $this->serviceLocator->get('table-gateway')->get('users');
            	$id = $model->insert($form->getData()); */

            	$this->flashmessenger()->addSuccessMessage('Solicitud enviada');

            	// redirect the user to the view user action
            	return $this->redirect()->toRoute('user/default', array (
	            	    'controller' => 'log',
	            	    'action'     => 'in',
            	));
            }
        }

        // pass the data to the view for visualization
        return array('form1'=> $form);
    }
}