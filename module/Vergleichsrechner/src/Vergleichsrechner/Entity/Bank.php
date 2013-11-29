<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Bank
 *
 * @ORM\Table(name="bank")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\BankRepository")
 * @Annotation\Name("bank")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Bank
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bankId;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_name", type="string", length=100, nullable=true)
     */
    private $bankName;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_logo", type="string", length=255, nullable=true)
     */
    private $bankLogo;

    /**
     * @var Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aktion", mappedBy="banken")
     **/
    private $aktionen;
    
    public function __construct() {
    	$this->aktionen = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bankId
     *
     * @return integer 
     */
    public function getBankId()
    {
        return $this->bankId;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     * @return Bank
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string 
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set bankLogo
     *
     * @param string $bankLogo
     * @return Bank
     */
    public function setBankLogo($bankLogo)
    {
        $this->bankLogo = $bankLogo;

        return $this;
    }

    /**
     * Get bankLogo
     *
     * @return string 
     */
    public function getBankLogo()
    {
        return $this->bankLogo;
    }

    /**
     * Set aktionen
     *
     * @param Doctrine\Common\Collections\Collection $aktionen
     * @return Bank
     */
    public function setAktionen(Doctrine\Common\Collections\Collection $aktionen)
    {
    	$this->aktionen = $aktionen;
    
    	return $this;
    }
    
    /**
     * Get aktionen
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAktionen()
    {
    	return $this->aktionen;
    }
    
    /**
     * Add aktion
     *
     * @param Aktion $aktion
     * @return Bank
     */
    public function addAktion(Aktion $aktion)
    {
    	if(!$this->aktionen->contains($aktion)){
    		$this->aktionen->add($aktion);
    	}
    
    	return $this;
    }    
    
    /**
     * Remove aktion
     *
     * @param Aktion $aktion
     * @return Bank
     */
    public function removeAktion(Aktion $aktion)
    {
    	if($this->aktionen->contains($aktion)){
    		$this->aktionen->removeElement($aktion);
    	}
    	return $this;
    }
    
    public function jsonSerialize() {
    	return [
	    	'bankId' => $this->getBankId(),
	    	'bankName' => $this->getBankName(),
	    	'bankLogo' => $this->getBankLogo(),
	    	'aktionen' => json_encode($this->getAktionen()),
    	];
    }
}
