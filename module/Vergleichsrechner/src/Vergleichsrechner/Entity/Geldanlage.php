<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Geldanlage
 *
 * @ORM\Table(name="produkt_geldanlage", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\GeldanlageRepository")
 */
class Geldanlage extends Produkt
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
     * @ORM\Column(name="produkt_mindestanlage", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktMindestanlage;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_hoechstanlage", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktHoechstanlage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_gesetzl_einlagvers", type="boolean", nullable=true)
     */
    protected $produktHasGesetzlEinlagvers;

    /**
     * @var EinlagensicherungLand
     *
     * @ORM\ManyToOne(targetEntity="EinlagensicherungLand")
     * @ORM\JoinColumn(name="einlagensicherung_land_id", referencedColumnName="einlagensicherung_land_id", nullable=true)
     */
    protected $einlagensicherungLand;

    /**
     * @var Zeitabschnitt
     *
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_zinsgutschrift", referencedColumnName="zeitabschnitt_id", nullable=true)
     */
    protected $produktZinsgutschrift;

    /**
     * @var Zeitabschnitt
     *
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_verfuegbarkeit", referencedColumnName="zeitabschnitt_id", nullable=true)
     */
    protected $produktVerfuegbarkeit;

    /**
     * @var Zeitabschnitt
     *
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_kuendbarkeit", referencedColumnName="zeitabschnitt_id", nullable=true)
     */
    protected $produktKuendbarkeit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_online_banking", type="boolean", nullable=true)
     */
    protected $produktHasOnlineBanking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_altersbeschraenkung", type="boolean", nullable=true)
     */
    protected $produktHasAltersbeschraenkung;

    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Kontozugriff")
     * @ORM\JoinTable(name="geldanlage_kontozugriff",
     *         joinColumns={@ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", onDelete="CASCADE")},
     *         inverseJoinColumns={@ORM\JoinColumn(name="kontozugriff_id", referencedColumnName="kontozugriff_id", onDelete="CASCADE")}
     * )
     */
    protected $ktozugriffe;
    
    /**
     * @ORM\OneToMany(targetEntity="GeldanlageKondition", mappedBy="produkt", cascade="remove")
     **/
    protected $konditionen;
    
    public function __construct() {
    	$this->ktozugriffe  = new ArrayCollection();
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
     * Set produktMindestanlage
     *
     * @param float $produktMindestanlage
     * @return Produkt
     */
    public function setProduktMindestanlage($produktMindestanlage)
    {
        $this->produktMindestanlage = $produktMindestanlage;

        return $this;
    }

    /**
     * Get produktMindestanlage
     *
     * @return float 
     */
    public function getProduktMindestanlage()
    {
        return $this->produktMindestanlage;
    }

    /**
     * Set produktHoechstanlage
     *
     * @param float $produktHoechstanlage
     * @return Produkt
     */
    public function setProduktHoechstanlage($produktHoechstanlage)
    {
        $this->produktHoechstanlage = $produktHoechstanlage;

        return $this;
    }

    /**
     * Get produktHoechstanlage
     *
     * @return float 
     */
    public function getProduktHoechstanlage()
    {
        return $this->produktHoechstanlage;
    }

    /**
     * Set produktHasGesetzlEinlagvers
     *
     * @param boolean $produktHasGesetzlEinlagvers
     * @return Produkt
     */
    public function setProduktHasGesetzlEinlagvers($produktHasGesetzlEinlagvers)
    {
        $this->produktHasGesetzlEinlagvers = $produktHasGesetzlEinlagvers;

        return $this;
    }

    /**
     * Get produktHasGesetzlEinlagvers
     *
     * @return boolean 
     */
    public function getProduktHasGesetzlEinlagvers()
    {
        return $this->produktHasGesetzlEinlagvers;
    }

    /**
     * Set einlagensicherungLand
     *
     * @param EinlagensicherungLand $einlagensicherungLand
     * @return Produkt
     */
    public function setEinlagensicherungLand($einlagensicherungLand)
    {
        $this->einlagensicherungLand = $einlagensicherungLand;

        return $this;
    }

    /**
     * Get einlagensicherungLand
     *
     * @return EinlagensicherungLand
     */
    public function getEinlagensicherungLand()
    {
        return $this->einlagensicherungLand;
    }

    /**
     * Set produktZinsgutschrift
     *
     * @param Zeitabschnitt $produktZinsgutschrift
     * @return Produkt
     */
    public function setProduktZinsgutschrift($produktZinsgutschrift)
    {
        $this->produktZinsgutschrift = $produktZinsgutschrift;

        return $this;
    }

    /**
     * Get produktZinsgutschrift
     *
     * @return Zeitabschnitt 
     */
    public function getProduktZinsgutschrift()
    {
        return $this->produktZinsgutschrift;
    }

    /**
     * Set produktVerfuegbarkeit
     *
     * @param Zeitabschnitt $produktVerfuegbarkeit
     * @return Produkt
     */
    public function setProduktVerfuegbarkeit($produktVerfuegbarkeit)
    {
        $this->produktVerfuegbarkeit = $produktVerfuegbarkeit;

        return $this;
    }

    /**
     * Get produktVerfuegbarkeit
     *
     * @return Zeitabschnitt 
     */
    public function getProduktVerfuegbarkeit()
    {
        return $this->produktVerfuegbarkeit;
    }

    /**
     * Set produktKuendbarkeit
     *
     * @param Zeitabschnitt $produktKuendbarkeit
     * @return Produkt
     */
    public function setProduktKuendbarkeit($produktKuendbarkeit)
    {
        $this->produktKuendbarkeit = $produktKuendbarkeit;

        return $this;
    }

    /**
     * Get produktKuendbarkeit
     *
     * @return Zeitabschnitt 
     */
    public function getProduktKuendbarkeit()
    {
        return $this->produktKuendbarkeit;
    }

    /**
     * Set produktHasOnlineBanking
     *
     * @param boolean $produktHasOnlineBanking
     * @return Produkt
     */
    public function setProduktHasOnlineBanking($produktHasOnlineBanking)
    {
        $this->produktHasOnlineBanking = $produktHasOnlineBanking;

        return $this;
    }

    /**
     * Get produktHasOnlineBanking
     *
     * @return boolean 
     */
    public function getProduktHasOnlineBanking()
    {
        return $this->produktHasOnlineBanking;
    }

    /**
     * Set produktHasAltersbeschraenkung
     *
     * @param boolean $produktHasAltersbeschraenkung
     * @return Produkt
     */
    public function setProduktHasAltersbeschraenkung($produktHasAltersbeschraenkung)
    {
        $this->produktHasAltersbeschraenkung = $produktHasAltersbeschraenkung;

        return $this;
    }

    /**
     * Get produktHasAltersbeschraenkung
     *
     * @return boolean 
     */
    public function getProduktHasAltersbeschraenkung()
    {
        return $this->produktHasAltersbeschraenkung;
    }
    
    /**
     * Set ktozugriffe
     *
     * @param ArrayCollection $kontozugriffe
     * @return Produkt
     */
    public function setKtozugriffe(ArrayCollection $ktozugriffe)
    {
    	$this->ktozugriffe = $ktozugriffe;
    
    	return $this;
    }    
    
    /**
     * Get ktozugriffe
     *
     * @return ArrayCollection
     */
    public function getKtozugriffe()
    {
    	return $this->ktozugriffe;
    }
    
    /**
     * Add ktozugriff
     *
     * @param Kontozugriff $ktozugriff
     * @return Produkt
     */
    public function addKtozugriff(Kontozugriff $ktozugriff)
    {
    	if(!$this->ktozugriffe->contains($ktozugriff)){
    		$this->ktozugriffe->add($ktozugriff);
    	}
    
    	return $this;
    }
    
    /**
     * Remove ktozugriff
     *
     * @return Produkt
     */
    public function removeKtozugriff(Kontozugriff $ktozugriff)
    {
    	if($this->ktozugriffe->contains($ktozugriff)){
    		$this->ktozugriffe->removeElement($ktozugriff);
    	}
    	return $this;
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
