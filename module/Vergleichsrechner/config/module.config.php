<?php
namespace Vergleichsrechner;

use Vergleichsrechner\Entity\User;
return array(
    'controllers' => array(
        'invokables' => array(
        		'Aktion' => 'Vergleichsrechner\Controller\AktionController',
				'Auth' => 'Vergleichsrechner\Controller\AuthController',
        		'Bank' => 'Vergleichsrechner\Controller\BankController',
        		'Bewertung' => 'Vergleichsrechner\Controller\BewertungController',
        		'EinlagensicherungLand' => 'Vergleichsrechner\Controller\EinlagensicherungLandController',
        		'Database' => 'Vergleichsrechner\Controller\DatabaseController',
        		'Kategorie' => 'Vergleichsrechner\Controller\KategorieController',
        		'Kontozugriff' => 'Vergleichsrechner\Controller\KontozugriffController',
        		'Legitimation' => 'Vergleichsrechner\Controller\LegitimationController',
        		'Produktart' => 'Vergleichsrechner\Controller\ProduktartController',
        		'Produkt' => 'Vergleichsrechner\Controller\ProduktController',
        		'Testbericht' => 'Vergleichsrechner\Controller\TestberichtController',
        		'User' => 'Vergleichsrechner\Controller\UserController',
        		'Welcome' => 'Vergleichsrechner\Controller\WelcomeController',
        		'Zeitabschnitt' => 'Vergleichsrechner\Controller\ZeitabschnittController',
        		'Zinssatz' => 'Vergleichsrechner\Controller\ZinssatzController',
        ),
    ),
    'router' => array(
        'routes' => array(
				'welcome' => array(
	                'type'    => 'Literal',
	                'options' => array(
	                    'route'    => '/welcome',
	                    'defaults' => array(
	                        'controller'    => 'Welcome',
	                        'action'        => 'index',
	                    ),
	                ),
	            ),
				'index' => array(
	        		'type'    => 'Literal',
	        		'options' => array(
	        				'route'    => '/',
	        				'defaults' => array(
	        						'controller'    => 'Auth',
	        						'action'        => 'login',
	        				),
	        		),
	        	),        					
				'login' => array(
	                'type'    => 'Literal',
	                'options' => array(
	                    'route'    => '/login',
	                    'defaults' => array(
	                        'controller'    => 'Auth',
	                        'action'        => 'login',
	                    ),
	                ),
	            ),		
        		'logout' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/logout',
        						'defaults' => array(
        								'controller'    => 'Auth',
        								'action'        => 'logout',
        						),
        				),
        		), 
        		'database' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/database',
        						'defaults' => array(
        								'controller'    => 'Database',
        								'action'        => 'index',
        						),
        				),
        				'may_terminate' => true,
        				'child_routes' => array(
        						'aktion' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/aktion/[:action]',
        										'constraints' => array(
        												'controller' => 'Aktion',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Aktion',
        												'action' => 'index',
        										),
        								),
        						),
        						'bank' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/bank/[:action]',
        										'constraints' => array(
        												'controller' => 'Bank',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Bank',
        												'action' => 'index',
        										),
        								),
        						),
        						'bewertung' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/bewertung/[:action]',
        										'constraints' => array(
        												'controller' => 'Bewertung',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Bewertung',
        												'action' => 'index',
        										),
        								),
        						),
        						'einlagensicherungLand' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/einlagensicherungLand/[:action]',
        										'constraints' => array(
        												'controller' => 'EinlagensicherungLand',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'EinlagensicherungLand',
        												'action' => 'index',
        										),
        								),
        						),
        						'kategorie' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/kategorie/[:action]',
        										'constraints' => array(
        												'controller' => 'Kategorie',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Kategorie',
        												'action' => 'index',
        										),
        								),
        						),
        						'kontozugriff' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/kontozugriff/[:action]',
        										'constraints' => array(
        												'controller' => 'Kontozugriff',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Kontozugriff',
        												'action' => 'index',
        										),
        								),
        						),
        						'legitimation' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/legitimation/[:action]',
        										'constraints' => array(
        												'controller' => 'Legitimation',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Legitimation',
        												'action' => 'index',
        										),
        								),
        						),
        						'produktart' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/produktart/[:action]',
        										'constraints' => array(
        												'controller' => 'Produktart',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Produktart',
        												'action' => 'index',
        										),
        								),
        						),
        						'testbericht' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/testbericht/[:action]',
        										'constraints' => array(
        												'controller' => 'Testbericht',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Testbericht',
        												'action' => 'index',
        										),
        								),
        						),
        						'user' => array(
        								'type'    => 'segment',
        								'options' => array(
        										'route'    => '/user/[:action]',
        										'constraints' => array(
        												'controller' => 'User',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        										),
        										'defaults' => array(
        												'controller' => 'User',
        												'action' => 'index',
        										),
        								),
        						),
        						'zeitabschnitt' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/zeitabschnitt/[:action]',
        										'constraints' => array(
        												'controller' => 'Zeitabschnitt',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Zeitabschnitt',
        												'action' => 'index',
        										),
        								),
        						),
        						'zinssatz' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/zinssatz/[:action]',
        										'constraints' => array(
        												'controller' => 'Zinssatz',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
        										),
        										'defaults' => array(
        												'controller' => 'Zinssatz',
        												'action' => 'index',
        										),
        								),
        						),
        				),
        		),
        		'produkt' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/produkt',
        						'defaults' => array(
        								'controller'    => 'Produkt',
        								'action'        => 'index',
        						),
        				),
        				'may_terminate' => true,
        				'child_routes' => array(
        						'default' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '[/:action[/:produktId]]',
        										'constraints' => array(
        												'controller' => 'Produkt',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        												'produktId' => '[0-9]*'
        										),
        										'defaults' => array(
        												'controller'    => 'Produkt',
        												'action'        => 'index',
        										),
        								),
        						),
        				),
        		),        		      			
        ),
    ),
	'navigation' => array(
			'default' => array(
					array(
						'label' => 'Start',
						'route' => 'welcome',
					),
					array(
						'label' => 'Datenbank',
						'route' => 'database',
					),
					array(
						'label' => 'Produkte',
						'route' => 'produkt',
						'pages' => array(
								array(
									'label' => 'Produktübersicht',
									'route' => 'produkt/default',
									'controller' => 'Produkt',
									'action' => 'index',
								),
								array(
									'label' => 'Produkt hinzufügen',
									'route' => 'produkt/default',
									'controller' => 'Produkt',
									'action' => 'edit',
								),
						),
					),
			),
	),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
		'factories' => array(
			'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
		),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        	'index/index'   		  => __DIR__ . '/../view/welcome/welcome.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
		'strategies' => array(
 			'ViewJsonStrategy',
		),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
	/*
	 * Doctrine 2 configuration
	 */	
	'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Vergleichsrechner\Entity\User', 
                'identity_property' => 'userEmail', 
                'credential_property' => 'userPassword', 
                'credential_callable' => function(User $user, $passwordGiven) {
                                        if ($user->getUserPassword() == hash('md5', $passwordGiven.$user->getUserSalt())) {
											return true;
                                        } else {
											return false;
                                        }
                },
            ),
        ),	
        'driver' => array(
            'Vergleichsrechner_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Vergleichsrechner/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
					'Vergleichsrechner\Entity' =>  'Vergleichsrechner_driver',
                ),
            ),
        ),
    ), 
);
