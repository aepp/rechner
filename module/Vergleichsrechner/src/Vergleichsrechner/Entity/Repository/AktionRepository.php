<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AktionRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT o FROM \Vergleichsrechner\Entity\Aktion o";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
    public function findAllJT($jtSorting, $jtStartIndex, $jtPageSize){
    	$dql = "SELECT o FROM \Vergleichsrechner\Entity\Aktion o ".
    			"ORDER BY o.".$jtSorting;
    	$query = $this->getEntityManager()->createQuery($dql);
    	$query->setMaxResults($jtPageSize);
    	$query->setFirstResult($jtStartIndex);
    	return $query->getResult();
    }
}