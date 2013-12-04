<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Produktart
 *
 * @ORM\Table(name="produktart")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ProduktartRepository")
 * @Annotation\Name("produktart")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Produktart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="produktart_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $produktartId;

    /**
     * @var string
     *
     * @ORM\Column(name="produktart_name", type="string", length=100, nullable=true)
     */
    protected $produktartName;



    /**
     * Get produktartId
     *
     * @return integer 
     */
    public function getProduktartId()
    {
        return $this->produktartId;
    }

    /**
     * Set produktartName
     *
     * @param string $produktartName
     * @return Produktart
     */
    public function setProduktartName($produktartName)
    {
        $this->produktartName = $produktartName;

        return $this;
    }

    /**
     * Get produktartName
     *
     * @return string 
     */
    public function getProduktartName()
    {
        return $this->produktartName;
    }

    public function jsonSerialize() {
    	return [
	    	'produktartId' => $this->getProduktartId(),
	    	'produktartName' => $this->getProduktartName(),
    	];
    }
}
