<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Kondition
 *
 * @ORM\Table(name="kondition")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KonditionRepository")
 * @Annotation\Name("kondition")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Kondition
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
     * @ORM\Column(name="kondition_einlage_von", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionEinlageVon;
    
    /**
     * @var float
     *
     * @ORM\Column(name="kondition_einlage_bis", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionEinlageBis;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_zinssatz", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionZinssatz;


  	/**
     * @var Produkt
     * 
     * @ORM\ManyToOne(targetEntity="Produkt", inversedBy="konditionen")
     * @ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", nullable=false)
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
    public function getKonditionEinlageVon()
    {
        return $this->konditionEinlageVon;
    }

    /**
     * 
     * @param float $konditionEinlageVon
     */
    public function setKonditionEinlageVon($konditionEinlageVon)
    {
        $this->konditionEinlageVon = $konditionEinlageVon;
    }

    /**
     * 
     * @return float
     */
    public function getKonditionEinlageBis()
    {
        return $this->konditionEinlageBis;
    }

    /**
     * 
     * @param float $konditionEinlageBis
     */
    public function setKonditionEinlageBis($konditionEinlageBis)
    {
        $this->konditionEinlageBis = $konditionEinlageBis;
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
    
    public function jsonSerialize() {
    	return [
	    	'konditionId' => $this->getKonditionId(),
	    	'konditionEinlageVon' => $this->getKonditionEinlageVon(),
	    	'konditionEinlageBis' => $this->getKonditionEinlageBis(),
	    	'konditionZinssatz' => $this->getKonditionZinssatz(),
	    	'konditionLaufzeit' => $this->getKonditionLaufzeit(),
	    	'produkt' => $this->getProdukt(),
    	];
    }
}
