<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Solicitud for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Solicitud\Controller;

use Solicitud\Form as Form;
use Solicitud\Form\SolicitudExtraordinario as ExtraordinarioForm;
use Zend\Mvc\Controller\AbstractActionController;
use Solicitud\Service\Factory\Database as DatabaseAdapter;
use Solicitud\Model\Solicitud as SolicitudModel;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbAdapter;
use Zend\Paginator\Paginator;



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

        $form = new ExtraordinarioForm($dbAdapter); // instanciar formulario

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

            	$info = $form->getData(); //The form's getData returns an array of key/value pairs

            	$solicitudesModel = $this->serviceLocator->get('table-gateway')->get('solicitudes');
            	$id = $solicitudesModel->insert($info); // @todo valor id: posible problema de concurrencia
            	$info['solicitud'] = $id; //id de solicitud insertada

            	$extraordModel = $this->serviceLocator->get('table-gateway')->get('solicitudExtraordinario');
            	$extraordModel->insert($info);

            	$this->flashmessenger()->addSuccessMessage('Solicitud enviada');

            	// redirect the user to its account home page
            	return $this->redirect()->toRoute('user/default', array (
	            	    'controller' => 'account',
	            	    'action'     => 'me',
            	));
            } else {
            	// debug code -- borrar despues!
            	$this->flashmessenger()->addSuccessMessage('no enviada');
            	$messages = $form->getMessages();
            }
        }

        // pass the data to the view for visualization
        return array('form1'=> $form);
    }


    public function listAction(){
		$extraordModel = new SolicitudModel();
		$result = $extraordModel->getSql()->select();

		$adapter = new PaginatorDbAdapter($result, $extraordModel->getAdapter());
		$paginator = new Paginator($adapter);
		$currentPage = $this->params('page', 1);
		$paginator->setCurrentPageNumber($currentPage);
		$paginator->setItemCountPerPage(10);

		return array('tests'=> $paginator,
					 'page'=> $currentPage
		);

	}


	public function createsolicitudrupturaAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudRupturaCorrelatividad($dbAdapter);

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

	public function createsolicitudcertificadoAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudCertificadoEstudios($dbAdapter);
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

	public function createsolicitudinscripciontardiaAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudInscripcionTardia($dbAdapter);
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

	public function createsolicitudcreditosAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudCreditos($dbAdapter);

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

	public function createsolicitudreduccionAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudReduccionAsistencia($dbAdapter);

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

	public function createsolicitudrevisionexamenAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudRevisionExamen($dbAdapter);
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

	public function createsolicituddesinscripcionAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudDesinscripcionExamen($dbAdapter);
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

	public function createsolicitudtraspasopagoAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudTraspasoPago($dbAdapter);
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

	public function createsolicitudrevisionescolaridadAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudRevisionEscolaridad($dbAdapter);
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

	public function createsolicitudcolaboradorcatedraAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudColaboradorCatedra($dbAdapter);
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

	public function createsolicitudtituloAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudTitulo($dbAdapter);
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

	public function createsolicitudconvalidacionmateriasAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudTitulo($dbAdapter);
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

	public function createsolicitudhomologacionmateriasAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudHomologacionMaterias($dbAdapter);
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

	public function createsolicitudtesisAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudTesis($dbAdapter);
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

	public function createsolicitudpasantiaAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudPasantia($dbAdapter);
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

	public function createsolicitudtutoriacatedraAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudTutoriaCatedra($dbAdapter);
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

	public function createsolicitudexoneracionAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudExoneracion($dbAdapter);
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

	public function createsolicitudmateriafueramallacurricularAction()
	{
		$database = new DatabaseAdapter(); //instanciamos la clase cuyo metodo nos devuelve el adaptador de nuestra bd
		$dbAdapter = $database->createService($this->getServiceLocator()); //llamamos al metodo que nos devuelve el adaptador de bd
		$form = new Form\SolicitudMateriaFueraMallaCurricular($dbAdapter);
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




