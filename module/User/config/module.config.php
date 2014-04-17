<?php
return array(
    'controllers' => array(
        'invokables' => array(
           // below is key              and below is the fully qualified class name
           'User\Controller\Account' => 'User\Controller\AccountController',
           'User\Controller\Log'     => 'User\Controller\LogController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/user',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'me',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            	'id'         => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
	'service_manager' => array (
		'factories' => array(
			'database' => 'User\Service\Factory\Database',
		),
		'invokables' => array(
			'table-gateway' => 'User\Service\Invokable\TableGateway',
		)
	),
	'table-gateway' => array(
		'map' => array(
			'users' => 'User\Model\User',
		)
	),

	// Below is the menu navigation for this module
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Usuario',
				'route' => 'user/default',
				'controller'=> 'account',
				'pages' => array(
					array(
						'label' => 'Mi cuenta',
						'route' => 'user/default',
						'controller' => 'account',
						'action' => 'me',
						'resource' => 'account',
						'privilege' => 'me',
					),
					array(
						'label' => 'Crear cuenta',
						'route' => 'user/default',
						'controller' => 'account',
						'action' => 'add',
						'resource' => 'account',
						'privilege' => 'add',
					),
					array(
						'label' => 'Editar',
						'route' => 'user/default',
						'controller' => 'account',
						'action' => 'edit',
						'resource' => 'account',
						'privilege' => 'edit',
					),
					array(
						'label' => 'Borrar cuenta',
						'route' => 'user/default',
						'controller' => 'account',
						'action' => 'delete',
						'resource' => 'account',
						'privilege' => 'delete',
					),
					array(
						'label' => 'Log in',
						// uri
						'route' => 'user/default',
						'controller' => 'log',
						'action'    => 'in',
						// acl
						'resource'  => 'log',
						'privilege' => 'in'
					),

					array(
						'label' => 'Registrarse',
						// uri
						'route' => 'user/default',
						'controller' => 'account',
						'action'     => 'register',
						// acl
						'resource' => 'account',
						'privilege' => 'register'
					),

					array(
						'label' => 'Log out',
						'route' => 'user/default',
						'controller' => 'log',
						'action'    => 'out',
						'resource'  => 'log',
						'privilege' => 'out'
					),
				)
			)
		)
	),
);
