<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produkt
 * 
 * @ORM\MappedSuperclass 
 */
class Produkt
{
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
     * @var Aktion
     *
     * @ORM\ManyToOne(targetEntity="Aktion")
     * @ORM\JoinColumn(name="aktion_id", referencedColumnName="aktion_id", nullable=true)
     */
    protected $aktion;

    /**
     * @var string
     *
     * @ORM\Column(name="produkt_ktofuehr_kost", type="text", nullable=true)
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
}
