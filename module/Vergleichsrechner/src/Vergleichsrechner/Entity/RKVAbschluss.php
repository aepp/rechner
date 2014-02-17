<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * RKVAbschluss
 *
 * @ORM\Table(name="rkv_abschluss")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\RKVAbschlussRepository")
 * @Annotation\Name("rkv_abschluss")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class RKVAbschluss
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rkv_abschluss_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $rkvAbschlussId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rkv_abschluss_name", type="text", nullable=false)
     */
    protected $rkvAbschlussName;
    
    public function __construct() {
    }

    /**
     * Get rkvAbschlussId
     *
     * @return integer 
     */
    public function getRkvAbschlussId()
    {
        return $this->rkvAbschlussId;
    }
    
    /**
     * Set rkvAbschlussName
     *
     * @param string $rkvAbschlussName
     * @return Aktion
     */
    public function setRkvAbschlussName($rkvAbschlussName)
    {
    	$this->rkvAbschlussName = $rkvAbschlussName;
    
    	return $this;
    }
    
    /**
     * Get rkvAbschlussName
     *
     * @return string
     */
    public function getRkvAbschlussName()
    {
    	return $this->rkvAbschlussName;
    }
        
    public function jsonSerialize() {
    	return [
	    	'rkvAbschlussId' => $this->getRkvAbschlussId(),
	    	'rkvAbschlussName' => $this->getRkvAbschlussName()
    	];
    }
}
