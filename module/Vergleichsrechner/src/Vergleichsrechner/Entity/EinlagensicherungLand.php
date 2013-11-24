<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * EinlagensicherungLand
 *
 * @ORM\Table(name="einlagensicherung_land")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\EinlagensicherungLandRepository")
 * @Annotation\Name("einlagensicherung_land")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class EinlagensicherungLand
{
    /**
     * @var integer
     *
     * @ORM\Column(name="einlagensicherung_land_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $einlagensicherungLandId;

    /**
     * @var string
     *
     * @ORM\Column(name="einlagensicherung_land_name", type="string", length=100, nullable=true)
     */
    private $einlagensicherungLandName;



    /**
     * Get einlagensicherungLandId
     *
     * @return integer 
     */
    public function getEinlagensicherungLandId()
    {
        return $this->einlagensicherungLandId;
    }

    /**
     * Set einlagensicherungLandName
     *
     * @param string $einlagensicherungLandName
     * @return EinlagensicherungLand
     */
    public function setEinlagensicherungLandName($einlagensicherungLandName)
    {
        $this->einlagensicherungLandName = $einlagensicherungLandName;

        return $this;
    }

    /**
     * Get einlagensicherungLandName
     *
     * @return string 
     */
    public function getEinlagensicherungLandName()
    {
        return $this->einlagensicherungLandName;
    }
    
    public function jsonSerialize() {
    	return [
	    	'einlagensicherungLandId' => $this->getEinlagensicherungLandId(),
	    	'einlagensicherungLandName' => $this->getEinlagensicherungLandName(),
    	];
    }
}
