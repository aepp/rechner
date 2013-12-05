<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Produkt
 *
 * @ORM\Table(name="produkt")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ProduktRepository")
 * @Annotation\Name("produkt")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Produkt
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
     * @var Kategorie
     *
     * @ORM\ManyToOne(targetEntity="Kategorie")
     * @ORM\JoinColumn(name="kategorie_id", referencedColumnName="kategorie_id")
     */
    protected $kategorie;

    /**
     * @var Produktart
     *
     * @ORM\ManyToOne(targetEntity="Produktart")
     * @ORM\JoinColumn(name="produktart_id", referencedColumnName="produktart_id")
     */
    protected $produktart;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_name", type="string", length=255, nullable=false)
     */
    protected $produktName;

    /**
     * @var Bank
     *
     * @ORM\ManyToOne(targetEntity="Bank")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     */
    protected $bank;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_online_abschluss", type="boolean", nullable=true)
     */
    protected $produktHasOnlineAbschluss;
    
    /**
     * @var Zinssatz
     *
     * @ORM\ManyToOne(targetEntity="Zinssatz")
     * @ORM\JoinColumn(name="zinssatz_id", referencedColumnName="zinssatz_id", nullable=true)
     */
    protected $zinssatz;
    
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
     * @var Aktion
     *
     * @ORM\ManyToOne(targetEntity="Aktion")
     * @ORM\JoinColumn(name="aktion_id", referencedColumnName="aktion_id", nullable=true)
     */
    protected $aktion;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_ktofuehr_kost", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktKtofuehrKost;

    /**
     * @var Zeitabschnitt
     *
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_ktofuehr_kost_fllg", referencedColumnName="zeitabschnitt_id", nullable=true)
     */
    protected $produktKtofuehrKostFllg;

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
     * @var Legitimation
     *
     * @ORM\ManyToOne(targetEntity="Legitimation")
     * @ORM\JoinColumn(name="legitimation_id", referencedColumnName="legitimation_id", nullable=true)
     */
    protected $legitimation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_altersbeschraenkung", type="boolean", nullable=true)
     */
    protected $produktHasAltersbeschraenkung;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="produkt_gueltig_seit", type="datetime", nullable=true)
     */
    protected $produktGueltigSeit;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_check", type="float", precision=10, scale=0, nullable=true)
     */
    protected $produktCheck;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_tipp", type="boolean", nullable=true)
     */
    protected $produktTipp;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_informationen", type="text", nullable=true)
     */
    protected $produktInformationen;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_url", type="text", nullable=true)
     */
    protected $produktUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_klickout_url", type="text", nullable=true)
     */
    protected $produktKlickoutUrl;

    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Kontozugriff")
     * @ORM\JoinTable(name="produkt_kontozugriff",
     *         joinColumns={@ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", onDelete="CASCADE")},
     *         inverseJoinColumns={@ORM\JoinColumn(name="kontozugriff_id", referencedColumnName="kontozugriff_id", onDelete="CASCADE")}
     * )
     */
    protected $ktozugriffe;
    
    /**
     * @ORM\OneToMany(targetEntity="Kondition", mappedBy="produkt", cascade="remove")
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
     * Set kategorie
     *
     * @param Kategorie $kategorieId
     * @return Produkt
     */
    public function setKategorie($kategorie)
    {
        $this->kategorie = $kategorie;

        return $this;
    }

    /**
     * Get kategorie
     *
     * @return Kategorie 
     */
    public function getKategorie()
    {
        return $this->kategorie;
    }

    /**
     * Set produktart
     *
     * @param Produktart $produktart
     * @return Produkt
     */
    public function setProduktart($produktart)
    {
        $this->produktart = $produktart;

        return $this;
    }

    /**
     * Get produktart
     *
     * @return Produktart 
     */
    public function getProduktart()
    {
        return $this->produktart;
    }

    /**
     * Set produktName
     *
     * @param string $produktName
     * @return Produkt
     */
    public function setProduktName($produktName)
    {
        $this->produktName = $produktName;

        return $this;
    }

    /**
     * Get produktName
     *
     * @return string 
     */
    public function getProduktName()
    {
        return $this->produktName;
    }

    /**
     * Set bank
     *
     * @param Bank $bank
     * @return Produkt
     */
    public function setBank($bank)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return Bank 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set produktHasOnlineAbschluss
     *
     * @param boolean $produktHasOnlineAbschluss
     * @return Produkt
     */
    public function setProduktHasOnlineAbschluss($produktHasOnlineAbschluss)
    {
        $this->produktHasOnlineAbschluss = $produktHasOnlineAbschluss;

        return $this;
    }

    /**
     * Get produktHasOnlineAbschluss
     *
     * @return boolean 
     */
    public function getProduktHasOnlineAbschluss()
    {
        return $this->produktHasOnlineAbschluss;
    }
    
    /**
     * Set zinssatz
     *
     * @param Zinssatz $zinssatz
     * @return Produkt
     */
    public function setZinssatz($zinssatz)
    {
    	$this->zinssatz = $zinssatz;
    
    	return $this;
    }
    
    /**
     * Get zinssatz
     *
     * @return Zinssatz
     */
    public function getZinssatz()
    {
    	return $this->zinssatz;
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
     * Set aktion
     *
     * @param Aktion $aktionId
     * @return Produkt
     */
    public function setAktion($aktion)
    {
        $this->aktion = $aktion;

        return $this;
    }

    /**
     * Get aktion
     *
     * @return Aktion 
     */
    public function getAktion()
    {
        return $this->aktion;
    }

    /**
     * Set produktKtofuehrKost
     *
     * @param float $produktKtofuehrKost
     * @return Produkt
     */
    public function setProduktKtofuehrKost($produktKtofuehrKost)
    {
        $this->produktKtofuehrKost = $produktKtofuehrKost;

        return $this;
    }

    /**
     * Get produktKtofuehrKost
     *
     * @return float 
     */
    public function getProduktKtofuehrKost()
    {
        return $this->produktKtofuehrKost;
    }

    /**
     * Set produktKtofuehrKostFllg
     *
     * @param Zeitabschnitt $produktKtofuehrKostFllg
     * @return Produkt
     */
    public function setProduktKtofuehrKostFllg($produktKtofuehrKostFllg)
    {
        $this->produktKtofuehrKostFllg = $produktKtofuehrKostFllg;

        return $this;
    }

    /**
     * Get produktKtofuehrKostFllg
     *
     * @return Zeitabschnitt 
     */
    public function getProduktKtofuehrKostFllg()
    {
        return $this->produktKtofuehrKostFllg;
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
     * Set legitimation
     *
     * @param Legitimation $legitimation
     * @return Produkt
     */
    public function setLegitimation($legitimation)
    {
        $this->legitimation = $legitimation;

        return $this;
    }

    /**
     * Get legitimation
     *
     * @return Legitimation 
     */
    public function getLegitimation()
    {
        return $this->legitimation;
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
     * Set produktGueltigSeit
     *
     * @param \DateTime $produktGueltigSeit
     * @return Produkt
     */
    public function setProduktGueltigSeit($produktGueltigSeit)
    {
        $this->produktGueltigSeit = $produktGueltigSeit;

        return $this;
    }

    /**
     * Get produktGueltigSeit
     *
     * @return \DateTime 
     */
    public function getProduktGueltigSeit()
    {
        return $this->produktGueltigSeit;
    }

    /**
     * Set produktCheck
     *
     * @param float $produktCheck
     * @return Produkt
     */
    public function setProduktCheck($produktCheck)
    {
        $this->produktCheck = $produktCheck;

        return $this;
    }

    /**
     * Get produktCheck
     *
     * @return float 
     */
    public function getProduktCheck()
    {
        return $this->produktCheck;
    }

    /**
     * Set produktTipp
     *
     * @param boolean $produktTipp
     * @return Produkt
     */
    public function setProduktTipp($produktTipp)
    {
        $this->produktTipp = $produktTipp;

        return $this;
    }

    /**
     * Get produktTipp
     *
     * @return boolean 
     */
    public function getProduktTipp()
    {
        return $this->produktTipp;
    }

    /**
     * Set produktInformationen
     *
     * @param string $produktInformationen
     * @return Produkt
     */
    public function setProduktInformationen($produktInformationen)
    {
        $this->produktInformationen = $produktInformationen;

        return $this;
    }

    /**
     * Get produktInformationen
     *
     * @return string 
     */
    public function getProduktInformationen()
    {
        return $this->produktInformationen;
    }

    /**
     * Set produktUrl
     *
     * @param string $produktUrl
     * @return Produkt
     */
    public function setProduktUrl($produktUrl)
    {
        $this->produktUrl = $produktUrl;

        return $this;
    }

    /**
     * Get produktUrl
     *
     * @return string 
     */
    public function getProduktUrl()
    {
        return $this->produktUrl;
    }

    /**
     * Set produktKlickoutUrl
     *
     * @param string $produktKlickoutUrl
     * @return Produkt
     */
    public function setProduktKlickoutUrl($produktKlickoutUrl)
    {
        $this->produktKlickoutUrl = $produktKlickoutUrl;

        return $this;
    }

    /**
     * Get produktKlickoutUrl
     *
     * @return string 
     */
    public function getProduktKlickoutUrl()
    {
        return $this->produktKlickoutUrl;
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
    		$ktozugriff->addProdukt($this);
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
    		$ktozugriff->removeProdukt($this);
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
