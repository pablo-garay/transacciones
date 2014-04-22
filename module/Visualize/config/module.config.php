<?php
return array(
    'controllers' => array(
        'invokables' => array(
            // below is key                      and below is the fully qualified class name
            'Visualize\Controller\Visualize' => 'Visualize\Controller\VisualizeController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'visualize' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/visualize',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Visualize\Controller',
                        'controller'    => 'Visualize',
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
            'Visualize' => __DIR__ . '/../view',
        ),
    ),
    
    // Below is the menu navigation for this module
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Visualize',
				'route' => 'visualize/default',
				'controller'=> 'index',
				'pages' => array(
					array(
						'label' => 'Visualizar solicitud',
						'route' => 'visualize/default',
						'controller' => 'index',
						'action' => 'create',
						'resource' => 'visualize',
						'privilege' => 'create',
					),
				)
			)
		)
	),
);
