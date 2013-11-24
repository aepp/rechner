<?php
namespace Vergleichsrechner\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BenutzerRepository extends EntityRepository{

    public function findAll(){
		$dql = "SELECT b FROM \Vergleichsrechner\Entity\Benutzer b";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
    }
}