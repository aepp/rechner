<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections;

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
    protected $kontozugriffId;

    /**
     * @var string
     *
     * @ORM\Column(name="kontozugriff_name", type="string", length=100, nullable=true)
     */
    protected $kontozugriffName;

    /**
     * @var Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Geldanlage", mappedBy="ktozugriffe")
     **/
    protected $produkte;

    public function __construct() {
    	$this->produkte = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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


    /**
     * Remove produkt
     *
     * @param Geldanlage $produkt
     * @return Kontozugriff
     */
    public function removeProdukt(Geldanlage $produkt)
    {
    	if($this->produkte->contains($produkt)){
    		$this->produkte->removeElement($produkt);
    	}
    	return $this;
    }    
    /**
     * Add produkt
     *
     * @param Geldanlage $produkt
     * @return Kontozugriff
     */
    public function addProdukt(Geldanlage $produkt)
    {
    	if(!$this->produkte->contains($produkt)){
    		$this->produkte->add($produkt);
    	}
    
    	return $this;
    }
    
    public function jsonSerialize() {
    	return [
	    	'kontozugriffId' => $this->getKontozugriffId(),
	    	'kontozugriffName' => $this->getKontozugriffName(),
    	];
    }
}
