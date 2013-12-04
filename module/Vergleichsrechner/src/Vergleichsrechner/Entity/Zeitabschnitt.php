<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Zeitabschnitt
 *
 * @ORM\Table(name="zeitabschnitt")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ZeitabschnittRepository")
 * @Annotation\Name("zeitabschnitt")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Zeitabschnitt
{
    /**
     * @var integer
     *
     * @ORM\Column(name="zeitabschnitt_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $zeitabschnittId;

    /**
     * @var string
     *
     * @ORM\Column(name="zeitabschnitt_name", type="string", length=100, nullable=false)
     */
    protected $zeitabschnittName;

    /**
     * @var integer
     *
     * @ORM\Column(name="zeitabschnitt_anz_tage", type="integer", nullable=true)
     */
    protected $zeitabschnittAnzTage;



    /**
     * Get zeitabschnittId
     *
     * @return integer 
     */
    public function getZeitabschnittId()
    {
        return $this->zeitabschnittId;
    }

    /**
     * Set zeitabschnittName
     *
     * @param string $zeitabschnittName
     * @return Zeitabschnitt
     */
    public function setZeitabschnittName($zeitabschnittName)
    {
        $this->zeitabschnittName = $zeitabschnittName;

        return $this;
    }

    /**
     * Get zeitabschnittName
     *
     * @return string 
     */
    public function getZeitabschnittName()
    {
        return $this->zeitabschnittName;
    }

    /**
     * Set zeitabschnittAnzTage
     *
     * @param integer $zeitabschnittAnzTage
     * @return Zeitabschnitt
     */
    public function setZeitabschnittAnzTage($zeitabschnittAnzTage)
    {
        $this->zeitabschnittAnzTage = $zeitabschnittAnzTage;

        return $this;
    }

    /**
     * Get zeitabschnittAnzTage
     *
     * @return integer 
     */
    public function getZeitabschnittAnzTage()
    {
        return $this->zeitabschnittAnzTage;
    }
    
    public function jsonSerialize() {
    	return [
	    	'zeitabschnittId' => $this->getZeitabschnittId(),
	    	'zeitabschnittName' => $this->getZeitabschnittName(),
    	];
    }
}
