<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Zinssatz
 *
 * @ORM\Table(name="zinssatz")
 * @ORM\Entity
 */
class Zinssatz
{
    /**
     * @var integer
     *
     * @ORM\Column(name="zinssatz_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $zinssatzId;

    /**
     * @var string
     *
     * @ORM\Column(name="zinssatz_name", type="string", length=100, nullable=true)
     */
    private $zinssatzName;



    /**
     * Get zinssatzId
     *
     * @return integer 
     */
    public function getZinssatzId()
    {
        return $this->zinssatzId;
    }

    /**
     * Set zinssatzName
     *
     * @param string $zinssatzName
     * @return Zinssatz
     */
    public function setZinssatzName($zinssatzName)
    {
        $this->zinssatzName = $zinssatzName;

        return $this;
    }

    /**
     * Get zinssatzName
     *
     * @return string 
     */
    public function getZinssatzName()
    {
        return $this->zinssatzName;
    }
}
