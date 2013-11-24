<?php
namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	/**
	 * for managing entities via Doctrine
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if (null === $this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->entityManager;
	}
}