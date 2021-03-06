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
class Kredit extends Produkt {

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
     * @var integer
     *
     * @ORM\Column(name="produkt_widerrufsfrist", type="integer", nullable=true)
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
     * */
    protected $konditionen;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_effektiver_jahreszins", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktEffektiverJahreszins;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_annahmerichtlinie", type="text", nullable=true)
     */
    protected $produktAnnahmerichtlinie;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_sollzins", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktSollzins;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_gesamtbetrag", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktGesamtbetrag;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_nettokreditsumme", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktNettokreditsumme;

    /**
     * @var RKVAbschluss
     *
     * @ORM\ManyToOne(targetEntity="RKVAbschluss")
     * @ORM\JoinColumn(name="rkv_abschluss_id", referencedColumnName="rkv_abschluss_id", nullable=true)
     */
    protected $rkvAbschluss;

    /**
     * @var Zeitabschnitt
     *
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_widerrufsfrist_zeiteinh", referencedColumnName="zeitabschnitt_id", nullable=true)
     */
    protected $produktWiderrufsfristZeiteinh;

    /**
     * @var integer
     *
     * @ORM\Column(name="produkt_laufzeit", type="integer", nullable=true)
     */
    protected $produktLaufzeit;

    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Kontozugriff")
     * @ORM\JoinTable(name="kredit_kontozugriff",
     *         joinColumns={@ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", onDelete="CASCADE")},
     *         inverseJoinColumns={@ORM\JoinColumn(name="kontozugriff_id", referencedColumnName="kontozugriff_id", onDelete="CASCADE")}
     * )
     */
    protected $ktozugriffe;

    public function __construct() {
        $this->ktozugriffe  = new ArrayCollection();
        $this->konditionen = new ArrayCollection();
    }

    public function getProduktWiderrufsfristZeiteinh() {
        return $this->produktWiderrufsfristZeiteinh;
    }

    public function setProduktWiderrufsfristZeiteinh($produktWiderrufsfristZeiteinh) {
        $this->produktWiderrufsfristZeiteinh = $produktWiderrufsfristZeiteinh;
    }

    public function getProduktLaufzeit() {
        return $this->produktLaufzeit;
    }

    public function setProduktLaufzeit($produktLaufzeit) {
        $this->produktLaufzeit = $produktLaufzeit;
    }

    public function getRkvAbschluss() {
        return $this->rkvAbschluss;
    }

    public function setRkvAbschluss($rkvAbschluss) {
        $this->rkvAbschluss = $rkvAbschluss;
    }

    public function getProduktNettokreditsumme() {
        return $this->produktNettokreditsumme;
    }

    public function setProduktNettokreditsumme($produktNettokreditsumme) {
        $this->produktNettokreditsumme = $produktNettokreditsumme;
    }

    public function getProduktGesamtbetrag() {
        return $this->produktGesamtbetrag;
    }

    public function setProduktGesamtbetrag($produktGesamtbetrag) {
        $this->produktGesamtbetrag = $produktGesamtbetrag;
    }

    public function getProduktSollzins() {
        return $this->produktSollzins;
    }

    public function setProduktSollzins($produktSollzins) {
        $this->produktSollzins = $produktSollzins;
    }

    public function getProduktAnnahmerichtlinie() {
        return $this->produktAnnahmerichtlinie;
    }

    public function setProduktAnnahmerichtlinie($produktAnnahmerichtlinie) {
        $this->produktAnnahmerichtlinie = $produktAnnahmerichtlinie;
    }

    public function getProduktEffektiverJahreszins() {
        return $this->produktEffektiverJahreszins;
    }

    public function setProduktEffektiverJahreszins($produktEffektiverJahreszins) {
        $this->produktEffektiverJahreszins = $produktEffektiverJahreszins;
    }

    /**
     * Get produktId
     *
     * @return integer 
     */
    public function getProduktId() {
        return $this->produktId;
    }

    /**
     * Set produktMinKredit
     *
     * @param float $produktMinKredit
     * @return Produkt
     */
    public function setProduktMinKredit($produktMinKredit) {
        $this->produktMinKredit = $produktMinKredit;

        return $this;
    }

    /**
     * Get produktMinKredit
     *
     * @return float 
     */
    public function getProduktMinKredit() {
        return $this->produktMinKredit;
    }

    /**
     * Set produktMaxKredit
     *
     * @param float $produktMaxKredit
     * @return Produkt
     */
    public function setProduktMaxKredit($produktMaxKredit) {
        $this->produktMaxKredit = $produktMaxKredit;

        return $this;
    }

    /**
     * Get produktMaxKredit
     *
     * @return float 
     */
    public function getProduktMaxKredit() {
        return $this->produktMaxKredit;
    }

    /**
     * Set produktIsBonitabh
     *
     * @param boolean $produktIsBonitabh
     * @return Produkt
     */
    public function setProduktIsBonitabh($produktIsBonitabh) {
        $this->produktIsBonitabh = $produktIsBonitabh;

        return $this;
    }

    /**
     * Get produktIsBonitabh
     *
     * @return boolean 
     */
    public function getProduktIsBonitabh() {
        return $this->produktIsBonitabh;
    }

    /**
     * Set produktBearbeitungsgebuehr
     *
     * @param String $produktBearbeitungsgebuehr
     * @return Produkt
     */
    public function setProduktBearbeitungsgebuehr($produktBearbeitungsgebuehr) {
        $this->produktBearbeitungsgebuehr = $produktBearbeitungsgebuehr;

        return $this;
    }

    /**
     * Get produktBearbeitungsgebuehr
     *
     * @return String
     */
    public function getProduktBearbeitungsgebuehr() {
        return $this->produktBearbeitungsgebuehr;
    }

    /**
     * Set produktWiderrufsfrist
     *
     * @param String $produktWiderrufsfrist
     * @return Produkt
     */
    public function setProduktWiderrufsfrist($produktWiderrufsfrist) {
        $this->produktWiderrufsfrist = $produktWiderrufsfrist;

        return $this;
    }

    /**
     * Get produktWiderrufsfrist
     *
     * @return String
     */
    public function getProduktWiderrufsfrist() {
        return $this->produktWiderrufsfrist;
    }

    /**
     * Set produktSondertilgungen
     *
     * @param String $produktSondertilgungen
     * @return Produkt
     */
    public function setProduktSondertilgungen($produktSondertilgungen) {
        $this->produktSondertilgungen = $produktSondertilgungen;

        return $this;
    }

    /**
     * Get produktWiderrufsfrist
     *
     * @return String
     */
    public function getProduktSondertilgungen() {
        return $this->produktSondertilgungen;
    }

    /**
     * 
     * Get konditionen
     * 
     * @return ArrayCollection
     */
    public function getKonditionen() {
        return $this->konditionen;
    }

    /**
     * 
     * Set konditionen
     * 
     * @param ArrayCollection $konditionen
     */
    public function setKonditionen(ArrayCollection $konditionen) {
        $this->konditionen = $konditionen;
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

}
