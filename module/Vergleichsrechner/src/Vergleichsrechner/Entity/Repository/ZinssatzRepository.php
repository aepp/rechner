<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ZinssatzRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT o FROM \Vergleichsrechner\Entity\Zinssatz o";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
    public function findAllJT($jtSorting, $jtStartIndex, $jtPageSize){
    	$dql = "SELECT o FROM \Vergleichsrechner\Entity\Zinssatz o ".
    			"ORDER BY o.".$jtSorting;
    	$query = $this->getEntityManager()->createQuery($dql);
    	$query->setMaxResults($jtPageSize);
    	$query->setFirstResult($jtStartIndex);
    	return $query->getResult();
    }
}