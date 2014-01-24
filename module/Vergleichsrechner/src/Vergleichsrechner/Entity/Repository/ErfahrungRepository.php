<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ErfahrungRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT o FROM \Vergleichsrechner\Entity\Erfahrung o ORDER BY o.erfahrungDatum DESC";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
}
?>