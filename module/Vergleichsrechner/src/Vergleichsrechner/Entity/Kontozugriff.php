<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Kontozugriff
 *
 * @ORM\Table(name="kontozugriff")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KontozugriffRepository")
 * @Annotation\Name("kontozugriff")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Kontozugriff
{
    /**
     * @var integer
     *
     * @ORM\Column(name="kontozugriff_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $kontozugriffId;

    /**
     * @var string
     *
     * @ORM\Column(name="kontozugriff_name", type="string", length=100, nullable=true)
     */
    private $kontozugriffName;



    /**
     * Get kontozugriffId
     *
     * @return integer 
     */
    public function getKontozugriffId()
    {
        return $this->kontozugriffId;
    }

    /**
     * Set kontozugriffName
     *
     * @param string $kontozugriffName
     * @return Kontozugriff
     */
    public function setKontozugriffName($kontozugriffName)
    {
        $this->kontozugriffName = $kontozugriffName;

        return $this;
    }

    /**
     * Get kontozugriffName
     *
     * @return string 
     */
    public function getKontozugriffName()
    {
        return $this->kontozugriffName;
    }

    public function jsonSerialize() {
    	return [
	    	'kontozugriffId' => $this->getKontozugriffId(),
	    	'kontozugriffName' => $this->getKontozugriffName(),
    	];
    }
}
