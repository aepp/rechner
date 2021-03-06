<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ZeitabschnittRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT o FROM \Vergleichsrechner\Entity\Zeitabschnitt o";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
    public function findAllJT($jtSorting, $jtStartIndex, $jtPageSize){
    	$dql = "SELECT o FROM \Vergleichsrechner\Entity\Zeitabschnitt o ".
    			"ORDER BY o.".$jtSorting;
    	$query = $this->getEntityManager()->createQuery($dql);
    	$query->setMaxResults($jtPageSize);
    	$query->setFirstResult($jtStartIndex);
    	return $query->getResult();
    }
    public function findYearandMonth(){
    	$dql = "SELECT o FROM \Vergleichsrechner\Entity\Zeitabschnitt o 
    			WHERE o.zeitabschnittId = 2 OR o.zeitabschnittId = 5";
    	$query = $this->getEntityManager()->createQuery($dql);
    	return $query->getResult();
    }
    public function findMonthAndDay(){
    	$dql = "SELECT o FROM \Vergleichsrechner\Entity\Zeitabschnitt o
    			WHERE o.zeitabschnittId = 1 OR o.zeitabschnittId = 2";
    	$query = $this->getEntityManager()->createQuery($dql);
    	return $query->getResult();
    }    
}