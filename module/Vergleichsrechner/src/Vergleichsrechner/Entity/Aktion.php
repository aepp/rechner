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
     * @ORM\Column(name="aktion_name", type="text", nullable=false)
     */
    private $aktionName;
    
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
     * @var Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Bank")
     * @ORM\JoinTable(name="aktion_bank",
     *         joinColumns={@ORM\JoinColumn(name="aktion_id", referencedColumnName="aktion_id", onDelete="CASCADE")},
     *         inverseJoinColumns={@ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id", onDelete="CASCADE")}
     * )
     */
    private $banken;
    
    public function __construct() {
    	$this->banken  = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set aktionName
     *
     * @param string $aktionName
     * @return Aktion
     */
    public function setAktionName($aktionName)
    {
    	$this->aktionName = $aktionName;
    
    	return $this;
    }
    
    /**
     * Get aktionName
     *
     * @return string
     */
    public function getAktionName()
    {
    	return $this->aktionName;
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

    /**
     * Set banken
     *
     * @param Doctrine\Common\Collections\Collection $banken
     * @return Aktion
     */
    public function setBanken($banken)
    {
    	$this->banken = $banken;
    
    	return $this;
    }
    
    /**
     * Get banken
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getBanken()
    {
    	return $this->banken;
    }
    
    /**
     * Add bank
     *
     * @param Bank $bank
     * @return Aktion
     */
    public function addBank(Bank $bank)
    {
    	if(!$this->banken->contains($bank)){
    		$this->banken->add($bank);
    		$bank->addAktion($this);
    	}
    
    	return $this;
    }
    
    /**
     * Remove bank
     *
     * @return Aktion
     */
    public function removeBank(Bank $bank)
    {
    	if($this->banken->contains($bank)){
    		$this->banken->removeElement($bank);
    		$bank->removeAktion($this);
    	}
    	return $this;
    }
        
    public function jsonSerialize() {
    	$banken_json = array();
    	foreach ($this->getBanken() as $bank){
    		array_push($banken_json, $bank->jsonSerialize());
    	}
    	return [
	    	'aktionId' => $this->getAktionId(),
	    	'aktionName' => $this->getAktionName(),
	    	'aktionBeschreibung' => $this->getAktionBeschreibung(),
	    	'aktionStartOn' => date_format($this->getAktionStartOn(), 'Y-m-d'),
	    	'aktionEndeOn' => date_format($this->getAktionEndeOn(), 'Y-m-d'),
	    	'aktionIsZuende' => $this->getAktionIsZuende() ? 1 : 0,
	    	'banken' => $banken_json,
    	];
    }
}
