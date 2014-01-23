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
        		'Erfahrung' => 'Vergleichsrechner\Controller\ErfahrungController',
        		'Database' => 'Vergleichsrechner\Controller\DatabaseController',
        		'Kategorie' => 'Vergleichsrechner\Controller\KategorieController',
        		'Kontozugriff' => 'Vergleichsrechner\Controller\KontozugriffController',
        		'Kredit' => 'Vergleichsrechner\Controller\KreditController',
        		'Legitimation' => 'Vergleichsrechner\Controller\LegitimationController',
        		'Produktart' => 'Vergleichsrechner\Controller\ProduktartController',
        		'Produktverwaltung' => 'Vergleichsrechner\Controller\ProduktverwaltungController',
        		'Geldanlage' => 'Vergleichsrechner\Controller\GeldanlageController',
        		'Testbericht' => 'Vergleichsrechner\Controller\TestberichtController',
        		'User' => 'Vergleichsrechner\Controller\UserController',
        		'Index' => 'Vergleichsrechner\Controller\IndexController',
        		'Zeitabschnitt' => 'Vergleichsrechner\Controller\ZeitabschnittController',
        		'Zinssatz' => 'Vergleichsrechner\Controller\ZinssatzController',
        ),
    ),
    'router' => array(
        'routes' => array(
				'index' => array(
	        		'type'    => 'Literal',
	        		'options' => array(
	        				'route'    => '/',
	        				'defaults' => array(
	        						'controller'    => 'Index',
	        						'action'        => 'index',
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
        		'produktverwaltung' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/produktverwaltung',
        						'defaults' => array(
        								'controller'    => 'Produktverwaltung',
        								'action'        => 'index',
        						),
        				),
        				'may_terminate' => true,
        				'child_routes' => array(
        						'geldanlage' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/geldanlage[/:action[/:produktId]]',
        										'constraints' => array(
        												'controller' => 'Geldanlage',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        												'produktId' => '[0-9]*'
        										),
        										'defaults' => array(
        												'controller' => 'Geldanlage',
        												'action' => 'index',
        										),
        								),
        						),
        						'kredit' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '/kredit[/:action[/:produktId]]',
        										'constraints' => array(
        												'controller' => 'Kredit',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        												'produktId' => '[0-9]*'
        										),
        										'defaults' => array(
        												'controller' => 'Kredit',
        												'action' => 'index',
        										),
        								),
        						),
        				),
        		),  
        		'erfahrungsberichte' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/erfahrungsberichte',
        						'defaults' => array(
        								'controller'    => 'Erfahrung',
        								'action'        => 'index',
        						),
        				),
        				'may_terminate' => true,
        				'child_routes' => array(
        						'default' => array(
        								'type'    => 'Segment',
        								'options' => array(
        										'route'    => '[/:action[/:erfahrungId]]',
        										'constraints' => array(
        												'controller' => 'Erfahrung',
        												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        												'erfahrungId' => '[0-9]*'
        										),
        										'defaults' => array(
        												'controller' => 'Erfahrung',
        												'action' => 'index',
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
						'label' => 'Home',
						'route' => 'index',
					),
					array(
						'label' => 'Datenbank',
						'route' => 'database',
					),
					array(
						'label' => 'Produktverwaltung',
						'route' => 'produktverwaltung',
						'pages' => array(
								array(
									'label' => 'Geldanlage',
									'route' => 'produktverwaltung/geldanlage',
									'pages' => array(
										array(
												'label' => 'Produktübersicht',
												'route' => 'produktverwaltung/geldanlage',
												'controller' => 'Geldanlage',
												'action' => 'index',
										),
										array(
											'label' => 'Produkt hinzufügen / bearbeiten',
											'route' => 'produktverwaltung/geldanlage',
											'controller' => 'Geldanlage',
											'action' => 'edit',
										),
									)
								),
								array(
										'label' => 'Kredite',
										'route' => 'produktverwaltung/kredit',
										'pages' => array(
												array(
														'label' => 'Produktübersicht',
														'route' => 'produktverwaltung/kredit',
														'controller' => 'Kredit',
														'action' => 'index',
												),
												array(
														'label' => 'Produkt hinzufügen / bearbeiten',
														'route' => 'produktverwaltung/kredit',
														'controller' => 'Kredit',
														'action' => 'edit',
												),
										)
								),
						),
					),
					array(
						'label' => 'Erfahrungsberichte',
						'route' => 'erfahrungsberichte',
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
        	'index/index'   		  => __DIR__ . '/../view/index/index.phtml',
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
