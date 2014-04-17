<?php
return array(
    'controllers' => array(
        'invokables' => array(
            // below is key                      and below is the fully qualified class name
            'Solicitud\Controller\Formulario' => 'Solicitud\Controller\FormularioController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'solicitud' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/solicitud',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Solicitud\Controller',
                        'controller'    => 'Formulario',
                        'action'        => 'index',
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
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
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
            'Solicitud' => __DIR__ . '/../view',
        ),
    ),
    
    // Below is the menu navigation for this module
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Solicitudes',
				'route' => 'solicitud/default',
				'controller'=> 'formulario',
				'pages' => array(
					array(
						'label' => 'Crear solicitud',
						'route' => 'solicitud/default',
						'controller' => 'formulario',
						'action' => 'create',
						'resource' => 'formulario',
						'privilege' => 'create',
					),
				)
			)
		)
	),
);
