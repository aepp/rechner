<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT u FROM \Vergleichsrechner\Entity\User u";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
    public function findAllJT($jtSorting, $jtStartIndex, $jtPageSize){
    	$dql = "SELECT u FROM \Vergleichsrechner\Entity\User u ".
    			"ORDER BY u.".$jtSorting;
    	$query = $this->getEntityManager()->createQuery($dql);
    	$query->setMaxResults($jtPageSize);
    	$query->setFirstResult($jtStartIndex);
    	return $query->getResult();
    }
}