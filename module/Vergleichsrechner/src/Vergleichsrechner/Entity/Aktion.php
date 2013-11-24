<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Aktion
 *
 * @ORM\Table(name="aktion")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\AktionRepository")
 * @Annotation\Name("aktion")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Aktion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="aktion_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $aktionId;

    /**
     * @var string
     *
     * @ORM\Column(name="aktion_beschreibung", type="text", nullable=true)
     */
    private $aktionBeschreibung;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="aktion_start_on", type="datetime", nullable=true)
     */
    private $aktionStartOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="aktion_ende_on", type="datetime", nullable=true)
     */
    private $aktionEndeOn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktion_is_zuende", type="boolean", nullable=true)
     */
    private $aktionIsZuende;



    /**
     * Get aktionId
     *
     * @return integer 
     */
    public function getAktionId()
    {
        return $this->aktionId;
    }

    /**
     * Set aktionBeschreibung
     *
     * @param string $aktionBeschreibung
     * @return Aktion
     */
    public function setAktionBeschreibung($aktionBeschreibung)
    {
        $this->aktionBeschreibung = $aktionBeschreibung;

        return $this;
    }

    /**
     * Get aktionBeschreibung
     *
     * @return string 
     */
    public function getAktionBeschreibung()
    {
        return $this->aktionBeschreibung;
    }

    /**
     * Set aktionStartOn
     *
     * @param \DateTime $aktionStartOn
     * @return Aktion
     */
    public function setAktionStartOn($aktionStartOn)
    {
        $this->aktionStartOn = $aktionStartOn;

        return $this;
    }

    /**
     * Get aktionStartOn
     *
     * @return \DateTime 
     */
    public function getAktionStartOn()
    {
        return $this->aktionStartOn;
    }

    /**
     * Set aktionEndeOn
     *
     * @param \DateTime $aktionEndeOn
     * @return Aktion
     */
    public function setAktionEndeOn($aktionEndeOn)
    {
        $this->aktionEndeOn = $aktionEndeOn;

        return $this;
    }

    /**
     * Get aktionEndeOn
     *
     * @return \DateTime 
     */
    public function getAktionEndeOn()
    {
        return $this->aktionEndeOn;
    }

    /**
     * Set aktionIsZuende
     *
     * @param boolean $aktionIsZuende
     * @return Aktion
     */
    public function setAktionIsZuende($aktionIsZuende)
    {
        $this->aktionIsZuende = $aktionIsZuende;

        return $this;
    }

    /**
     * Get aktionIsZuende
     *
     * @return boolean 
     */
    public function getAktionIsZuende()
    {
        return $this->aktionIsZuende;
    }
    
    public function jsonSerialize() {
    	return [
	    	'aktionId' => $this->getAktionId(),
	    	'aktionBeschreibung' => $this->getAktionBeschreibung(),
	    	'aktionStartOn' => date_format($this->getAktionStartOn(), 'Y-m-d'),
	    	'aktionEndeOn' => date_format($this->getAktionEndeOn(), 'Y-m-d'),
	    	'aktionIsZuende' => $this->getAktionIsZuende() ? 1 : 0,
    	];
    }
}
