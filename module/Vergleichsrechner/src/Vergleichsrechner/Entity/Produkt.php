<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
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
    private $produktId;

    /**
     * @var integer
     *
     * @ORM\Column(name="kategorie_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Kategorie")
     * @ORM\JoinColumn(name="kategorie_id", referencedColumnName="kategorie_id")
     */
    private $kategorieId;

    /**
     * @var integer
     *
     * @ORM\Column(name="produktart_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Produktart")
     * @ORM\JoinColumn(name="produktart_id", referencedColumnName="produktart_id")
     */
    private $produktartId;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_name", type="string", length=255, nullable=false)
     */
    private $produktName;

    /**
     * @var integer
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Bank")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     */
    private $bankId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_online_abschluss", type="boolean", nullable=false)
     */
    private $produktHasOnlineAbschluss;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_mindestanlage", type="float", precision=10, scale=0, nullable=true)
     */
    private $produktMindestanlage;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_hoechstanlage", type="float", precision=10, scale=0, nullable=true)
     */
    private $produktHoechstanlage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_gesetzl_einlagvers", type="boolean", nullable=false)
     */
    private $produktHasGesetzlEinlagvers;

    /**
     * @var integer
     *
     * @ORM\Column(name="einlagensicherung_land_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="EinlagensicherungLand")
     * @ORM\JoinColumn(name="einlagensicherung_land_id", referencedColumnName="einlagensicherung_land_id")
     */
    private $einlagensicherungLandId;

    /**
     * @var integer
     *
     * @ORM\Column(name="aktion_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Aktion")
     * @ORM\JoinColumn(name="aktion_id", referencedColumnName="aktion_id")
     */
    private $aktionId;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_ktofuehr_kost", type="float", precision=10, scale=0, nullable=true)
     */
    private $produktKtofuehrKost;

    /**
     * @var integer
     *
     * @ORM\Column(name="produkt_ktofuehr_kost_fllg", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_ktofuehr_kost_fllg", referencedColumnName="zeitabschnitt_id")
     */
    private $produktKtofuehrKostFllg;

    /**
     * @var integer
     *
     * @ORM\Column(name="produkt_zinsgutschrift", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_zinsgutschrift", referencedColumnName="zeitabschnitt_id")
     */
    private $produktZinsgutschrift;

    /**
     * @var integer
     *
     * @ORM\Column(name="produkt_verfuegbarkeit", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_verfuegbarkeit", referencedColumnName="zeitabschnitt_id")
     */
    private $produktVerfuegbarkeit;

    /**
     * @var integer
     *
     * @ORM\Column(name="produkt_kuendbarkeit", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Zeitabschnitt")
     * @ORM\JoinColumn(name="produkt_kuendbarkeit", referencedColumnName="zeitabschnitt_id")
     */
    private $produktKuendbarkeit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_online_banking", type="boolean", nullable=true)
     */
    private $produktHasOnlineBanking;

    /**
     * @var integer
     *
     * @ORM\Column(name="legitimation_id", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Legitimation")
     * @ORM\JoinColumn(name="legitimation_id", referencedColumnName="legitimation_id")
     */
    private $legitimationId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_has_altersbeschraenkung", type="boolean", nullable=true)
     */
    private $produktHasAltersbeschraenkung;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="produkt_gueltig_seit", type="datetime", nullable=true)
     */
    private $produktGueltigSeit;

    /**
     * @var float
     *
     * @ORM\Column(name="produkt_check", type="float", precision=10, scale=0, nullable=true)
     */
    private $produktCheck;

    /**
     * @var boolean
     *
     * @ORM\Column(name="produkt_tipp", type="boolean", nullable=true)
     */
    private $produktTipp;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_informationen", type="text", nullable=true)
     */
    private $produktInformationen;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_url", type="text", nullable=true)
     */
    private $produktUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_klickout_url", type="text", nullable=true)
     */
    private $produktKlickoutUrl;

    /**
     * @ORM\JoinTable(name="produkt_kontozugriff",
     *         joinColumns={@ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", onDelete="CASCADE")},
     *         inverseJoinColumns={@ORM\JoinColumn(name="kontozugriff_id", referencedColumnName="kontozugriff_id", onDelete="CASCADE")}
     * )
     * @var Kontozugriff[]
     */
    private $kontozugriffe;


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
     * Set kategorieId
     *
     * @param integer $kategorieId
     * @return Produkt
     */
    public function setKategorieId($kategorieId)
    {
        $this->kategorieId = $kategorieId;

        return $this;
    }

    /**
     * Get kategorieId
     *
     * @return integer 
     */
    public function getKategorieId()
    {
        return $this->kategorieId;
    }

    /**
     * Set produktartId
     *
     * @param integer $produktartId
     * @return Produkt
     */
    public function setProduktartId($produktartId)
    {
        $this->produktartId = $produktartId;

        return $this;
    }

    /**
     * Get produktartId
     *
     * @return integer 
     */
    public function getProduktartId()
    {
        return $this->produktartId;
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
     * Set bankId
     *
     * @param integer $bankId
     * @return Produkt
     */
    public function setBankId($bankId)
    {
        $this->bankId = $bankId;

        return $this;
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
     * Set einlagensicherungLandId
     *
     * @param integer $einlagensicherungLandId
     * @return Produkt
     */
    public function setEinlagensicherungLandId($einlagensicherungLandId)
    {
        $this->einlagensicherungLandId = $einlagensicherungLandId;

        return $this;
    }

    /**
     * Get einlagensicherungLandId
     *
     * @return integer 
     */
    public function getEinlagensicherungLandId()
    {
        return $this->einlagensicherungLandId;
    }

    /**
     * Set produktAktion
     *
     * @param string $produktAktion
     * @return Produkt
     */
    public function setProduktAktion($produktAktion)
    {
        $this->produktAktion = $produktAktion;

        return $this;
    }

    /**
     * Get produktAktion
     *
     * @return string 
     */
    public function getProduktAktion()
    {
        return $this->produktAktion;
    }

    /**
     * Set aktionId
     *
     * @param integer $aktionId
     * @return Produkt
     */
    public function setAktionId($aktionId)
    {
        $this->aktionId = $aktionId;

        return $this;
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
     * @param integer $produktKtofuehrKostFllg
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
     * @return integer 
     */
    public function getProduktKtofuehrKostFllg()
    {
        return $this->produktKtofuehrKostFllg;
    }

    /**
     * Set produktZinsgutschrift
     *
     * @param integer $produktZinsgutschrift
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
     * @return integer 
     */
    public function getProduktZinsgutschrift()
    {
        return $this->produktZinsgutschrift;
    }

    /**
     * Set produktVerfuegbarkeit
     *
     * @param integer $produktVerfuegbarkeit
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
     * @return integer 
     */
    public function getProduktVerfuegbarkeit()
    {
        return $this->produktVerfuegbarkeit;
    }

    /**
     * Set produktKuendbarkeit
     *
     * @param integer $produktKuendbarkeit
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
     * @return integer 
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
     * Set legitimationId
     *
     * @param integer $legitimationId
     * @return Produkt
     */
    public function setLegitimationId($legitimationId)
    {
        $this->legitimationId = $legitimationId;

        return $this;
    }

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
     * Set kontozugriffe
     *
     * @param array $kontozugriffe
     * @return Produkt
     */
    public function setKontozugriffe($kontozugriffe)
    {
    	$this->kontozugriffe = $kontozugriffe;
    
    	return $this;
    }    
    
    /**
     * Get kontozugriffe
     *
     * @return array
     */
    public function getKontozugriffe()
    {
    	return $this->kontozugriffe;
    }
}
