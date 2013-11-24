<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class KategorieRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT k FROM \Vergleichsrechner\Entity\Kategorie k";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
    public function findAllJT($jtSorting, $jtStartIndex, $jtPageSize){
    	$dql = "SELECT k FROM \Vergleichsrechner\Entity\Kategorie k ".
    			"ORDER BY k.".$jtSorting;
    	$query = $this->getEntityManager()->createQuery($dql);
    	$query->setMaxResults($jtPageSize);
    	$query->setFirstResult($jtStartIndex);
    	return $query->getResult();
    }
}