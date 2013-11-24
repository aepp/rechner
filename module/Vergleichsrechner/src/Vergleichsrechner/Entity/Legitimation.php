<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Legitimation
 *
 * @ORM\Table(name="legitimation")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\LegitimationRepository")
 * @Annotation\Name("legitimation")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Legitimation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="legitimation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $legitimationId;

    /**
     * @var string
     *
     * @ORM\Column(name="legitimation_name", type="string", length=100, nullable=true)
     */
    private $legitimationName;



    /**
     * Get legitimationId
     *
     * @return integer 
     */
    public function getLegitimationId()
    {
        return $this->legitimationId;
    }

    /**
     * Set legitimationName
     *
     * @param string $legitimationName
     * @return Legitimation
     */
    public function setLegitimationName($legitimationName)
    {
        $this->legitimationName = $legitimationName;

        return $this;
    }

    /**
     * Get legitimationName
     *
     * @return string 
     */
    public function getLegitimationName()
    {
        return $this->legitimationName;
    }

    public function jsonSerialize() {
    	return [
	    	'legitimationId' => $this->getLegitimationId(),
	    	'legitimationName' => $this->getLegitimationName(),
    	];
    }   
}
