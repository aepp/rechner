<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Kredit
 *
 * @ORM\Table(name="produkt_kredit", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KreditRepository")
 */
class Kredit extends Produkt
{
    /**
     * @var integer
     *
     * @ORM\Column(name="produkt_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $produktId;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_minkredit", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktMinKredit;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_maxkredit", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktMaxKredit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_is_bonitabh", type="boolean", nullable=true)
     */
    protected $produktIsBonitabh;
    
    /**
     * @var float
     *
     * @ORM\Column(name="produkt_bearbeitungsgebuehr", type="float", precision=10, scale=0, nullable=true)
     */
    
    protected $produktBearbeitungsgebuehr;
    
    /**
     * @var string
     *
     * @ORM\Column(name="produkt_widerrufsfrist", type="string", length=255, nullable=true)
     */
    protected $produktWiderrufsfrist;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_sondertilgungen", type="string", length=255, nullable=true)
     */
    protected $produktSondertilgungen;
    
    /**
     * @ORM\OneToMany(targetEntity="KreditKondition", mappedBy="produkt", cascade="remove")
     **/
    protected $konditionen;
    
    public function __construct() {
    	$this->konditionen  = new ArrayCollection();
    }

    /**
     * Get produktId
     *
     * @return integer 
     */
    public function getProduktId()
    {
        return $this->produktId;
    }
    
    /**
     * Set produktMinKredit
     *
     * @param float $produktMinKredit
     * @return Produkt
     */
    public function setProduktMinKredit($produktMinKredit)
    {
        $this->produktMinKredit = $produktMinKredit;

        return $this;
    }

    /**
     * Get produktMinKredit
     *
     * @return float 
     */
    public function getProduktMinKredit()
    {
        return $this->produktMinKredit;
    }

    /**
     * Set produktMaxKredit
     *
     * @param float $produktMaxKredit
     * @return Produkt
     */
    public function setProduktMaxKredit($produktMaxKredit)
    {
        $this->produktMaxKredit = $produktMaxKredit;

        return $this;
    }

    /**
     * Get produktMaxKredit
     *
     * @return float 
     */
    public function getProduktMaxKredit()
    {
        return $this->produktMaxKredit;
    }

    /**
     * Set produktIsBonitabh
     *
     * @param boolean $produktIsBonitabh
     * @return Produkt
     */
    public function setProduktIsBonitabh($produktIsBonitabh)
    {
        $this->produktIsBonitabh = $produktIsBonitabh;

        return $this;
    }

    /**
     * Get produktIsBonitabh
     *
     * @return boolean 
     */
    public function getProduktIsBonitabh()
    {
        return $this->produktIsBonitabh;
    }
    
    /**
     * Set produktBearbeitungsgebuehr
     *
     * @param String $produktBearbeitungsgebuehr
     * @return Produkt
     */
    public function setProduktBearbeitungsgebuehr($produktBearbeitungsgebuehr)
    {
    	$this->produktBearbeitungsgebuehr = $produktBearbeitungsgebuehr;
    
    	return $this;
    }
    
    /**
     * Get produktBearbeitungsgebuehr
     *
     * @return String
     */
    public function getProduktBearbeitungsgebuehr()
    {
    	return $this->produktBearbeitungsgebuehr;
    }

    /**
     * Set produktWiderrufsfrist
     *
     * @param String $produktWiderrufsfrist
     * @return Produkt
     */
    public function setProduktWiderrufsfrist($produktWiderrufsfrist)
    {
    	$this->produktWiderrufsfrist = $produktWiderrufsfrist;
    
    	return $this;
    }
    
    /**
     * Get produktWiderrufsfrist
     *
     * @return String
     */
    public function getProduktWiderrufsfrist()
    {
    	return $this->produktWiderrufsfrist;
    }

    /**
     * Set produktSondertilgungen
     *
     * @param String $produktSondertilgungen
     * @return Produkt
     */
    public function setProduktSondertilgungen($produktSondertilgungen)
    {
    	$this->produktSondertilgungen = $produktSondertilgungen;
    
    	return $this;
    }
    
    /**
     * Get produktWiderrufsfrist
     *
     * @return String
     */
    public function getProduktSondertilgungen()
    {
    	return $this->produktSondertilgungen;
    }
    
    /**
     * 
     * Get konditionen
     * 
     * @return ArrayCollection
     */
    public function getKonditionen()
    {
        return $this->konditionen;
    }

    /**
     * 
     * Set konditionen
     * 
     * @param ArrayCollection $konditionen
     */
    public function setKonditionen(ArrayCollection $konditionen)
    {
        $this->konditionen = $konditionen;
    }
}
