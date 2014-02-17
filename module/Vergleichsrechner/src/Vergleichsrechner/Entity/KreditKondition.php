<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KreditKondition
 *
 * @ORM\Table(name="kredit_kondition")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KreditKonditionRepository")
 */
class KreditKondition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="kondition_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $konditionId;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_laufzeit", type="integer", nullable=false)
     */
    protected $konditionLaufzeit;
        
    /**
     * @var float
     *
     * @ORM\Column(name="kondition_kredit_von", type="float", precision=10, scale=0, nullable=true)
     */
    protected $konditionKreditVon;
    
    /**
     * @var float
     *
     * @ORM\Column(name="kondition_kredit_bis", type="float", precision=10, scale=0, nullable=true)
     */
    protected $konditionKreditBis;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_zinssatz", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionZinssatz;

    /**
     * @var integer
     *
     * @ORM\Column(name="kondition_risikoklasse", type="integer", nullable=false)
     */
    protected $konditionRisikoklasse;
    
    /**
     * @var float
     *
     * @ORM\Column(name="kondition_provision_lead", type="float", precision=10, scale=0, nullable=true)
     */
    protected $konditionProvisionLead;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_provision_sale", type="float", precision=10, scale=0, nullable=true)
     */
    protected $konditionProvisionSale;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_schwelle", type="float", precision=10, scale=0, nullable=true)
     */
    protected $konditionSchwelle;
    
  	/**
     * @var Produkt
     * 
     * @ORM\ManyToOne(targetEntity="Kredit", inversedBy="konditionen")
     * @ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", nullable=true)
     **/
    protected $produkt;
    
    /**
     * 
     * @return integer
     */
    public function getKonditionId()
    {
        return $this->konditionId;
    }

    /**
     * 
     * @return float#
     */
    public function getKonditionKreditVon()
    {
        return $this->konditionKreditVon;
    }

    /**
     * 
     * @param float $konditionKreditVon
     */
    public function setKonditionKreditVon($konditionKreditVon)
    {
        $this->konditionKreditVon = $konditionKreditVon;
    }

    /**
     * 
     * @return float
     */
    public function getKonditionKreditBis()
    {
        return $this->konditionKreditBis;
    }

    /**
     * 
     * @param float $konditionKreditBis
     */
    public function setKonditionKreditBis($konditionKreditBis)
    {
        $this->konditionKreditBis = $konditionKreditBis;
    }

    /**
     * 
     * @return float
     */
    public function getKonditionZinssatz()
    {
        return $this->konditionZinssatz;
    }

    /**
     * 
     * @param float $konditionZinssatz
     */
    public function setKonditionZinssatz($konditionZinssatz)
    {
        $this->konditionZinssatz = $konditionZinssatz;
    }

    /**
     * 
     * @return Produkt
     */
    public function getProdukt()
    {
        return $this->produkt;
    }

    /**
     * 
     * @param Produkt $produkt
     */
    public function setProdukt($produkt)
    {
        $this->produkt = $produkt;
    }

    /**
     * 
     * @return integer
     */
    public function getKonditionLaufzeit()
    {
        return $this->konditionLaufzeit;
    }

    /**
     * 
     * @param integer $konditionLaufzeit
     */
    public function setKonditionLaufzeit($konditionLaufzeit)
    {
        $this->konditionLaufzeit = $konditionLaufzeit;
    }

    /**
     *
     * @return integer
     */
    public function getKonditionRisikoklasse()
    {
    	return $this->konditionRisikoklasse;
    }
    
    /**
     *
     * @param integer $konditionRisikoklasse
     */
    public function setKonditionRisikoklasse($konditionRisikoklasse)
    {
    	$this->konditionRisikoklasse = $konditionRisikoklasse;
    }

    /**
     *
     * @return float
     */
    public function getKonditionProvisionLead()
    {
    	return $this->konditionProvisionLead;
    }
    
    /**
     *
     * @param float $konditionProvisionLead
     */
    public function setKonditionProvisionLead($konditionProvisionLead)
    {
    	$this->konditionProvisionLead = $konditionProvisionLead;
    }    

    /**
     *
     * @return float
     */
    public function getKonditionProvisionSale()
    {
    	return $this->konditionProvisionSale;
    }
    
    /**
     *
     * @param float $konditionProvisionSale
     */
    public function setKonditionProvisionSale($konditionProvisionSale)
    {
    	$this->konditionProvisionSale = $konditionProvisionSale;
    }
    
    public function getKonditionSchwelle() 
    {
      return $this->konditionSchwelle;
    }
    
    public function setKonditionSchwelle($konditionSchwelle ) 
    {
      $this->konditionSchwelle = $konditionSchwelle ;
    }
    
    public function jsonSerialize() {
    	return [
	    	'konditionId' => $this->getKonditionId(),
	    	'konditionKreditVon' => $this->getKonditionKreditVon(),
	    	'konditionKreditBis' => $this->getKonditionKreditBis(),
	    	'konditionZinssatz' => $this->getKonditionZinssatz(),
	    	'konditionLaufzeit' => $this->getKonditionLaufzeit(),
	    	'konditionRisikoklasse' => $this->getKonditionRisikoklasse(),
	    	'konditionProvisionLead' => $this->getKonditionProvisionLead(),
	    	'konditionProvisionSale' => $this->getKonditionProvisionSale(),
	    	'konditionSchwelle' => $this->getKonditionSchwelle(),
	    	'produkt' => $this->getProdukt(),
    	];
    }
}
