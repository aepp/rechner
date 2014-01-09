<?php
namespace Vergleichsrechner;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Mvc\Router\Http\RouteMatch;

class Module
{
	protected $whitelist = array('login');
	
    public function onBootstrap(MvcEvent $e)
    {
    	date_default_timezone_set( 'Europe/Berlin' );
    	
    	$app = $e->getApplication();
        $eventManager = $app->getEventManager();
        $sm  = $app->getServiceManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        /*
         * Filter to protect all pages from not
         * authorized users
         */
        
        $list = $this->whitelist;
        $auth = $sm->get('doctrine.authenticationservice.orm_default');

        $eventManager->attach(MvcEvent::EVENT_ROUTE, function($e) use ($list, $auth) {
        	
        	$match = $e->getRouteMatch();

        	// No route match, this is a 404
        	if (!$match instanceof  RouteMatch) {
        		return;
        	}
        
        	// Route is whitelisted
        	$name = $match->getMatchedRouteName();
        	if (in_array($name, $list)) {
        		return;
        	}
        	
        	// User is authenticated
        	if ($auth->hasIdentity()) {
        		return;
        	}
        
        	// Redirect to the user login page, as an example
        	$router   = $e->getRouter();
        	$url      = $router->assemble(array(), array(
        			'name' => 'login'
        	));
        
        	$response = $e->getResponse();
        	$response->getHeaders()->addHeaderLine('Location', $url);
        	$response->setStatusCode(302);
        
        	return $response;
        }, -100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Zend\Authentication\AuthenticationService' => function($serviceManager) {
    						return $serviceManager->get('doctrine.authenticationservice.orm_default');
    
    					},
    			)
    	);
    }
    public function getFormElementConfig()
    {
    	return array(
    			'invokables' => array(
    					'GeldanlageForm' => 'Vergleichsrechner\Form\GeldanlageForm',
    					'KreditForm' => 'Vergleichsrechner\Form\KreditForm',
    					'LoginForm' => 'Vergleichsrechner\Form\LoginForm',
    			),
    			'initializers' => array(
    					'ObjectManagerInitializer' => function ($element, $formElements) {
    						// look if the form implements the ObjectManagerAwareInterface
    						if ($element instanceof ObjectManagerAwareInterface) {
    							// locate the EntityManager using the serviceLocator
    							$services = $formElements->getServiceLocator();
    							$entityManager = $services->get('Doctrine\ORM\EntityManager');
    							// set the forms EntityManager or Objectmanager, 2 names for the same thing
    							$element->setObjectManager($entityManager);
    						}
    					}
    			)
		);
    }    
}
